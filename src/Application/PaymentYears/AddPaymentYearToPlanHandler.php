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

namespace Payman\Application\PaymentYears;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentYear\Cost;
use Payman\Domain\Model\PaymentYear\CouldNotAddPaymentYearToPlan;
use Payman\Domain\Model\PaymentYear\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearRepository;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;

final class AddPaymentYearToPlanHandler
{
    private PaymentYearRepository $repository;

    public function __construct(PaymentYearRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddPaymentYearToPlan $command): void
    {
        $paymentYearStatus = PaymentYearStatus::fromInt($command->status());
        $paymentPlanId = PaymentPlanId::fromString($command->paymentPlanId());

        if (
            $paymentYearStatus->isCurrent()
            && $this->repository->currentPaymentYearExistsInPaymentPlan($paymentPlanId)
        ) {
            throw CouldNotAddPaymentYearToPlan::becauseCurrentPaymentYearAlreadyExists($paymentPlanId);
        }

        $id = $this->repository->nextIdentity();

        $this->repository->store(
            new PaymentYear(
                $id,
                $command->name(),
                $paymentPlanId,
                Cost::fromInt($command->cost()),
                $paymentYearStatus,
                $command->visible()
            )
        );
    }
}
