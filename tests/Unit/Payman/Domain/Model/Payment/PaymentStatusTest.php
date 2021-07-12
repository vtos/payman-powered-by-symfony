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

use Payman\Domain\Model\Payment\PaymentStatus;
use PHPUnit\Framework\TestCase;

final class PaymentStatusTest extends TestCase
{
    /**
     * @test
     */
    public function it_acquires_correct_status_option_with_named_constructor(): void
    {
        $this->assertTrue(
            PaymentStatus::none()
                ->isNone()
        );

        $this->assertTrue(
            PaymentStatus::rejected()
                ->isRejected()
        );

        $this->assertTrue(
            PaymentStatus::accepted()
                ->isAccepted()
        );
    }
}
