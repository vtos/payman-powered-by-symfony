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

namespace Payman\Domain\Model\Payment;

use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\Student\StudentId;

final class Payment
{
    private StudentId $studentId;

    private PaymentYearId $paymentYearId;

    private PaymentAmount $amount;

    private PaymentStatus $status;

    private function __construct(
        StudentId $studentId,
        PaymentYearId $paymentYearId,
        PaymentAmount $amount,
        PaymentStatus $status
    ) {
        $this->studentId = $studentId;
        $this->paymentYearId = $paymentYearId;
        $this->amount = $amount;
        $this->status = $status;
    }

    public static function createWithNoStatus(
        StudentId $studentId,
        PaymentYearId $paymentYearId,
        PaymentAmount $amount
    ): self {
        return new self(
            $studentId,
            $paymentYearId,
            $amount,
            PaymentStatus::none()
        );
    }
}
