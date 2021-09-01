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

namespace Tests\Functional\REST;

use Tests\FunctionalTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;

class CreatePaymentPlanTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function created_payment_plan_appears_in_payment_plans_list(): void
    {
        $client = HttpClient::create();
        $createPlanResponse = $client->request(
            'POST',
            'http://localhost:8000/api/v1/plans', [
                'query' => [
                    'name' => 'Payment Plan Functional Test',
                    'type' => PaymentPlanType::LOCALS,
                ],
            ]
        );

        $this->assertEquals(Response::HTTP_OK, $createPlanResponse->getStatusCode());
        $this->assertJson($createPlanResponse->getContent());

        $plansListResponse = $client->request(
            'GET',
            'http://localhost:8000/api/v1/plans'
        );

        $this->assertEquals(Response::HTTP_OK, $plansListResponse->getStatusCode());
        $this->assertJson($plansListResponse->getContent());

        $this->assertJsonStringEqualsJsonString(
            '[
                '.$createPlanResponse->getContent().'
            ]',
            $plansListResponse->getContent()
        );
    }
}
