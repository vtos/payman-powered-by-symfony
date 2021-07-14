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

namespace Payman\Application\PaymentYears;

use RuntimeException;
use Payman\Domain\Model\PaymentPlan\CouldNotAddPaymentYearToPaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanRepository;
use Payman\Domain\Model\PaymentYear\Cost;
use Payman\Domain\Model\PaymentYear\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\PaymentYear\PaymentYearRepository;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;

final class AddPaymentYearToPlanHandler
{
    private PaymentYearRepository $paymentYearRepository;

    private PaymentPlanRepository $paymentPlanRepository;

    public function __construct(
        PaymentYearRepository $paymentYearRepository,
        PaymentPlanRepository $paymentPlanRepository
    ) {
        $this->paymentYearRepository = $paymentYearRepository;
        $this->paymentPlanRepository = $paymentPlanRepository;
    }

    /**
     * @throws RuntimeException
     */
    public function handle(AddPaymentYearToPlan $command): void
    {
        $paymentPlanId = PaymentPlanId::fromString(
            $command->paymentPlanId()
        );

        if (!$this->paymentPlanRepository->paymentPlanExists($paymentPlanId)) {
            throw CouldNotAddPaymentYearToPaymentPlan::becausePaymentPlanNotExists($paymentPlanId);
        }
        if ($this->paymentYearRepository->currentPaymentYearExistsInPaymentPlanWithId($paymentPlanId)) {
            throw CouldNotAddPaymentYearToPaymentPlan::becauseCurrentPaymentYearAlreadyExists($paymentPlanId);
        }

        $id = $this->paymentYearRepository->nextIdentity();

        $this->paymentYearRepository->store(
            new PaymentYear(
                PaymentYearId::fromString($id),
                $command->name(),
                $paymentPlanId,
                Cost::fromInt($command->cost()),
                PaymentYearStatus::fromInt($command->status()),
                $command->visible()
            )
        );
    }
}
