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

namespace Tests\Unit\Payman\Domain\Model\PaymentPlan;

use PHPUnit\Framework\TestCase;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;
use Payman\Domain\Model\PaymentPlan\PaymentPlan;

final class PaymentPlanTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_renamed(): void
    {
        $paymentPlan = new PaymentPlan(
            PaymentPlanId::fromString('1'),
            PaymentPlanName::fromString('Payment Plan'),
            PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
        );

        $newName = PaymentPlanName::fromString('Payment Plan Renamed');
        $paymentPlan->rename($newName);

        $this->assertEquals(
            new PaymentPlan(
                PaymentPlanId::fromString('1'),
                $newName,
                PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
            ),
            $paymentPlan
        );
    }

    /**
     * @test
     */
    public function it_can_change_type(): void
    {
        $paymentPlan = new PaymentPlan(
            PaymentPlanId::fromString('1'),
            PaymentPlanName::fromString('Payment Plan'),
            PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
        );

        $newType = PaymentPlanType::fromInt(PaymentPlanType::FOREIGNERS);
        $paymentPlan->changeType($newType);

        $this->assertEquals(
            new PaymentPlan(
                PaymentPlanId::fromString('1'),
                PaymentPlanName::fromString('Payment Plan'),
                $newType
            ),
            $paymentPlan
        );
    }
}
