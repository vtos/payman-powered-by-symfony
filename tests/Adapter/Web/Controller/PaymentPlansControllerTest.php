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

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Payman\Application\CreatePaymentPlan\CreatePaymentPlanService;
use Payman\Application\CreatePaymentPlan\CreatePaymentPlan;
use Payman\Application\PaymentPlans\PaymentPlan as PaymentPlanReadModel;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;

class PaymentPlansControllerTest extends KernelTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel([
            'environment' => 'test',
            'debug' => true,
        ]);
    }

    /**
     * @test
     */
    public function it_calls_service_to_create_a_payment_plan(): void
    {
        $createPlanService = $this->createMock(CreatePaymentPlanService::class);
        self::$kernel->getContainer()->set(CreatePaymentPlanService::class, $createPlanService);

        $createPlanService->expects($this->once())
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

        static::$kernel->handle(
            Request::create(
                '/api/v1/plans',
                'POST',
                [
                    'name' => 'Create Payment Plan Test',
                    'type' => PaymentPlanType::LOCALS,
                ]
            )
        );
    }
}
