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

namespace Tests\Unit\Payman\Domain\Model\Payment;

use Payman\Domain\Model\Payment\CouldNotChangePaymentStatus;
use Payman\Domain\Model\Payment\Payment;
use Payman\Domain\Model\Payment\PaymentAmount;
use Payman\Domain\Model\Payment\PaymentId;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\Student\StudentId;
use PHPUnit\Framework\TestCase;

final class PaymentTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_only_be_rejected_with_no_status(): void
    {
        $payment = Payment::createWithNoStatus(
            PaymentId::fromString('1'),
            StudentId::fromString('1'),
            PaymentYearId::fromString('1'),
            PaymentAmount::fromInt(50)
        );
        // This will change the status to 'accepted'.
        $payment->accept();

        $this->expectException(CouldNotChangePaymentStatus::class);
        $payment->reject();
    }

    /**
     * @test
     */
    public function it_can_only_be_accepted_with_no_status(): void
    {
        $payment = Payment::createWithNoStatus(
            PaymentId::fromString('1'),
            StudentId::fromString('1'),
            PaymentYearId::fromString('1'),
            PaymentAmount::fromInt(50)
        );
        // This will change the status to 'rejected'.
        $payment->reject();

        $this->expectException(CouldNotChangePaymentStatus::class);
        $payment->accept();
    }

    /**
     * @test
     */
    public function it_can_only_be_approved_with_accepted_status(): void
    {
        $payment = Payment::createWithNoStatus(
            PaymentId::fromString('1'),
            StudentId::fromString('1'),
            PaymentYearId::fromString('1'),
            PaymentAmount::fromInt(50)
        );

        $this->expectException(CouldNotChangePaymentStatus::class);
        $payment->approve();
    }
}
