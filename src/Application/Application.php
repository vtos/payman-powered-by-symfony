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

namespace Payman\Application;

use Payman\Application\PaymentPlans\RemovePaymentPlan;
use Payman\Application\PaymentPlans\RemovePaymentPlanHandler;
use Payman\Application\PaymentPlans\UpdatePaymentPlan;
use Payman\Application\PaymentPlans\UpdatePaymentPlanHandler;
use Payman\Application\Payments\UploadPayment;
use Payman\Application\Payments\UploadPaymentHandler;
use Payman\Application\PaymentYears\AddPaymentYearToPlan;
use Payman\Application\PaymentYears\AddPaymentYearToPlanHandler;
use Payman\Application\PaymentYears\RemovePaymentYear;
use Payman\Application\PaymentYears\RemovePaymentYearHandler;
use Payman\Application\Students\AssignStudentToPlan;
use Payman\Application\Students\AssignStudentToPlanHandler;
use Payman\Application\Students\UnassignStudentFromPlan;
use Payman\Application\Students\UnassignStudentFromPlanHandler;

final class Application
{

    private UpdatePaymentPlanHandler $updatePaymentPlanHandler;

    private RemovePaymentPlanHandler $removePaymentPlanHandler;

    private AddPaymentYearToPlanHandler $addPaymentYearToPlanHandler;

    private RemovePaymentYearHandler $removePaymentYearHandler;

    private AssignStudentToPlanHandler $assignStudentToPlanHandler;

    private UnassignStudentFromPlanHandler $unassignStudentFromPlanHandler;

    private UploadPaymentHandler $uploadPaymentHandler;

    public function __construct(
        UpdatePaymentPlanHandler $updatePaymentPlanHandler,
        RemovePaymentPlanHandler $removePaymentPlanHandler,
        AddPaymentYearToPlanHandler $addPaymentYearToPlanHandler,
        RemovePaymentYearHandler $removePaymentYearHandler,
        AssignStudentToPlanHandler $assignStudentToPlanHandler,
        UnassignStudentFromPlanHandler $unassignStudentFromPlanHandler,
        UploadPaymentHandler $uploadPaymentHandler

    ) {
        $this->updatePaymentPlanHandler = $updatePaymentPlanHandler;
        $this->removePaymentPlanHandler = $removePaymentPlanHandler;
        $this->addPaymentYearToPlanHandler = $addPaymentYearToPlanHandler;
        $this->removePaymentYearHandler = $removePaymentYearHandler;
        $this->assignStudentToPlanHandler = $assignStudentToPlanHandler;
        $this->unassignStudentFromPlanHandler = $unassignStudentFromPlanHandler;
        $this->uploadPaymentHandler = $uploadPaymentHandler;
    }

    public function updatePaymentPlan(UpdatePaymentPlan $command): void
    {
        $this->updatePaymentPlanHandler->handle($command);
    }

    public function removePaymentPlan(RemovePaymentPlan $command): void
    {
        $this->removePaymentPlanHandler->handle($command);
    }

    public function addPaymentYearToPlan(AddPaymentYearToPlan $command): void
    {
        $this->addPaymentYearToPlanHandler->handle($command);
    }

    public function removePaymentYearFromPlan(RemovePaymentYear $command): void
    {
        $this->removePaymentYearHandler->handle($command);
    }

    public function assignStudentToPlan(AssignStudentToPlan $command): void
    {
        $this->assignStudentToPlanHandler->handle($command);
    }

    public function unassignStudentFromPlan(UnassignStudentFromPlan $command): void
    {
        $this->unassignStudentFromPlanHandler->handle($command);
    }

    public function uploadPayment(UploadPayment $command): void
    {
        $this->uploadPaymentHandler->handle($command);
    }
}
