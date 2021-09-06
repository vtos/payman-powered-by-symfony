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

    private AddPaymentYearToPlanHandler $addPaymentYearToPlanHandler;

    private RemovePaymentYearHandler $removePaymentYearHandler;

    private AssignStudentToPlanHandler $assignStudentToPlanHandler;

    private UnassignStudentFromPlanHandler $unassignStudentFromPlanHandler;

    private UploadPaymentHandler $uploadPaymentHandler;

    public function __construct(
        AddPaymentYearToPlanHandler $addPaymentYearToPlanHandler,
        RemovePaymentYearHandler $removePaymentYearHandler,
        AssignStudentToPlanHandler $assignStudentToPlanHandler,
        UnassignStudentFromPlanHandler $unassignStudentFromPlanHandler,
        UploadPaymentHandler $uploadPaymentHandler

    ) {
        $this->addPaymentYearToPlanHandler = $addPaymentYearToPlanHandler;
        $this->removePaymentYearHandler = $removePaymentYearHandler;
        $this->assignStudentToPlanHandler = $assignStudentToPlanHandler;
        $this->unassignStudentFromPlanHandler = $unassignStudentFromPlanHandler;
        $this->uploadPaymentHandler = $uploadPaymentHandler;
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
