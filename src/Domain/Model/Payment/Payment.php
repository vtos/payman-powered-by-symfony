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

namespace Payman\Domain\Model\Payment;

use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\Student\StudentId;

final class Payment
{
    private PaymentId $id;

    private StudentId $studentId;

    private PaymentYearId $paymentYearId;

    private PaymentAmount $amount;

    private PaymentStatus $status;

    private function __construct(
        PaymentId $id,
        StudentId $studentId,
        PaymentYearId $paymentYearId,
        PaymentAmount $amount,
        PaymentStatus $status
    ) {
        $this->id = $id;
        $this->studentId = $studentId;
        $this->paymentYearId = $paymentYearId;
        $this->amount = $amount;
        $this->status = $status;
    }

    public static function createWithNoStatus(
        PaymentId $id,
        StudentId $studentId,
        PaymentYearId $paymentYearId,
        PaymentAmount $amount
    ): self {
        return new self(
            $id,
            $studentId,
            $paymentYearId,
            $amount,
            PaymentStatus::none()
        );
    }

    public function accept(): void
    {
        if (!$this->status->isNone()) {
            throw CouldNotChangePaymentStatus::becauseOnlyNoStatusPaymentCanBeAccepted();
        }
        $this->status = PaymentStatus::accepted();
    }

    public function approve(): void
    {
        if (!$this->status->isAccepted()) {
            throw CouldNotChangePaymentStatus::becauseOnlyAcceptedPaymentCanBeApproved();
        }
        $this->status = PaymentStatus::approved();
    }

    public function reject(): void
    {
        if (!$this->status->isNone()) {
            throw CouldNotChangePaymentStatus::becauseOnlyNoStatusPaymentCanBeRejected();
        }
        $this->status = PaymentStatus::rejected();
    }
}
