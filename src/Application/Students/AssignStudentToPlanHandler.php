<?php
/**
 * This file is part of the vtos/payment-powered-by-symfony application.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright 2021 Vitaly Potenko <potenkov@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 * @link https://github.com/vtos/payman-powered-by-symfony GitHub
 */

declare(strict_types=1);

namespace Payman\Application\Students;

use RuntimeException;
use Payman\Domain\Model\Student\CouldNotAssignStudentToPaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanRepository;
use Payman\Domain\Model\Student\Student;
use Payman\Domain\Model\Student\StudentId;
use Payman\Domain\Model\Student\StudentRepository;

final class AssignStudentToPlanHandler
{
    private StudentRepository $studentRepository;

    private PaymentPlanRepository $paymentPlanRepository;

    public function __construct(
        StudentRepository $studentRepository,
        PaymentPlanRepository $paymentPlanRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->paymentPlanRepository = $paymentPlanRepository;
    }

    /**
     * @param AssignStudentToPlan $command
     * @throws RuntimeException
     */
    public function handle(AssignStudentToPlan $command): void
    {
        $studentId = StudentId::fromString($command->studentId());
        $paymentPlanId = PaymentPlanId::fromString($command->paymentPlanId());

        if (!$this->paymentPlanRepository->paymentPlanExists($paymentPlanId)) {
            throw CouldNotAssignStudentToPaymentPlan::becausePaymentPlanNotExistsWithId($paymentPlanId);
        }
        if ($this->studentRepository->studentWithPaymentPlanExists($studentId, $paymentPlanId)) {
            throw CouldNotAssignStudentToPaymentPlan::becauseAlreadyAssigned($studentId, $paymentPlanId);
        }

        $this->studentRepository->store(
            new Student(
                $studentId,
                $command->studentName(),
                $paymentPlanId
            )
        );
    }
}
