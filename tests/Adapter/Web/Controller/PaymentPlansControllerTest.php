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

namespace Tests\Adapter\Web\Controller;

use PHPUnit\Framework\TestCase;
use Payman\Application\PaymentPlans\CreatePaymentPlanHandler;
use Payman\Application\PaymentPlans\CreatePaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;
use Payman\Application\PaymentPlans\PaymentPlan as PaymentPlanReadModel;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;

class PaymentPlansControllerTest extends TestCase
{

    /**
     * @test
     */
    public function it_calls_service_to_create_a_payment_plan(): void
    {
        $createOrderService = $this->createMock(CreatePaymentPlanHandler::class);
        $createOrderService->expects($this->once())
            ->method('handle')
            ->with(
                new CreatePaymentPlan('Create Payment Plan Test', PaymentPlanType::LOCALS)
            )
            ->will(
                $this->returnValue(
                    new PaymentPlanReadModel(
                        PaymentPlanId::fromString('1'),
                        PaymentPlanName::fromString('Create Payment Plan Test')
                    )
                )
            );
    }
}
