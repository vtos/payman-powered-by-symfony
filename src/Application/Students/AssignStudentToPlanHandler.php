<?php
/**
 * This file is part of the vtos/payment application.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright 2021 Vitaly Potenko <potenkov@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 * @link https://github.com/vtos/payman GitHub
 */

declare(strict_types=1);

namespace Payman\Application\Students;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\Student\Student;
use Payman\Domain\Model\Student\StudentId;
use Payman\Domain\Model\Student\StudentRepository;

final class AssignStudentToPlanHandler
{
    private StudentRepository $repository;

    public function __construct(StudentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AssignStudentToPlan $command): void
    {
        $this->repository->store(
            new Student(
                StudentId::fromString($command->studentId()),
                $command->studentName(),
                PaymentPlanId::fromString($command->paymentPlanId())
            )
        );
    }
}
