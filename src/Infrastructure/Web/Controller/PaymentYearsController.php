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

use RuntimeException;
use Payman\Application\Application;
use Payman\Application\PaymentYears\AddPaymentYearToPlan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PaymentYearsController extends AbstractController
{
    /**
     * @Route("/api/v1/years", methods={"POST"}, name="api_create_payment_year")
     */
    public function create(Request $request, Application $application): JsonResponse
    {
        // TODO: add request data validation.

        try {
            $application->addPaymentYearToPlan(
                new AddPaymentYearToPlan(
                    $request->get('name'),
                    $request->get('payment_plan_id'),
                    (int)$request->get('cost'),
                    (int)$request->get('status'),
                    (bool)$request->get('visible')
                )
            );
        } catch(RuntimeException $exception) {
            return new JsonResponse(
                [
                    'error' => true,
                    'message' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return new JsonResponse(
            [
                'error' => false,
            ],
            Response::HTTP_CREATED
        );
    }
}
