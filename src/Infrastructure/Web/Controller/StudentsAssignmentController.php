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
use Payman\Application\Students\UnassignStudentFromPlan;
use Payman\Application\Application;
use Payman\Application\Students\AssignStudentToPlan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StudentsAssignmentController extends AbstractController
{
    /**
     * @Route("/api/v1/assign", methods={"POST"}, name="api_assign_student")
     */
    public function assign(Request $request, Application $application): JsonResponse
    {
        $studentId = $request->get('student_id');
        $studentName = $request->get('student_name');
        $paymentPlanId = $request->get('payment_plan_id');

        // TODO: add validation.

        try {
            $application->assignStudentToPlan(
                new AssignStudentToPlan(
                    $studentId,
                    $studentName,
                    $paymentPlanId
                )
            );
        } catch (RuntimeException $exception) {
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

    /**
     * @Route("/api/v1/unassign", methods={"POST"}, name="api_unassign_student")
     */
    public function unassign(Request $request, Application $application): JsonResponse
    {
        $studentId = $request->get('student_id');

        // TODO: add validation.

        try {
            $application->unassignStudentFromPlan(
                new UnassignStudentFromPlan($studentId)
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
            Response::HTTP_ACCEPTED
        );
    }
}
