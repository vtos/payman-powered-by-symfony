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

namespace Payman\Infrastructure\Web\Controller;

use Payman\Application\RemovePaymentPlan\RemovePaymentPlan;
use Payman\Application\RemovePaymentPlan\RemovePaymentPlanService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Payman\Application\CreatePaymentPlan\CreatePaymentPlanService;
use Payman\Application\CreatePaymentPlan\CreatePaymentPlan;
use Payman\Application\ListPaymentPlans\PaymentPlans;
use Payman\Application\ListPaymentPlans\PaymentPlan as PaymentPlanReadModel;

final class PaymentPlansController extends AbstractController
{
    /**
     * @Route("/api/v1/plans", methods={"GET"}, name="api_payment_plans_list")
     */
    public function list(PaymentPlans $paymentPlans): JsonResponse
    {
        return new JsonResponse(
            array_map(
                function(PaymentPlanReadModel $paymentPlan) {
                    return $paymentPlan->asArray();
                },
                $paymentPlans->list()
            )
        );
    }

    /**
     * @Route("/api/v1/plans", methods={"POST"}, name="api_create_payment_plan")
     */
    public function create(Request $request, CreatePaymentPlanService $createPaymentPlanService): JsonResponse
    {
        $paymentPlan = $createPaymentPlanService->handle(
            new CreatePaymentPlan(
                $request->get('name'),
                (int)$request->get('type')
            )
        );

        // Return read model of the created payment plan.
        return new JsonResponse(
            $paymentPlan->asArray()
        );
    }

    /**
     * @Route("/api/v1/plans/{id}", methods={"DELETE"}, name="api_remove_payment_plan")
     */
    public function remove(string $id, RemovePaymentPlanService $removePaymentPlanService): JsonResponse
    {
        $removePaymentPlanService->handle(
            new RemovePaymentPlan($id)
        );
        return new JsonResponse();
    }
}
