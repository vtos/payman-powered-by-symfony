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

namespace Payman\Application\Payments;

use Payman\Domain\Model\Payment\Payment;
use Payman\Domain\Model\Payment\PaymentAmount;
use Payman\Domain\Model\Payment\PaymentRepository;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\Student\StudentId;

final class UploadPaymentHandler
{
    private PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UploadPayment $command): void
    {
        $payment = Payment::createWithNoStatus(
            $this->repository->nextIdentity(),
            StudentId::fromString($command->studentId()),
            PaymentYearId::fromString($command->paymentYearId()),
            PaymentAmount::fromInt($command->amount())
        );
        $this->repository->store($payment);
    }
}
