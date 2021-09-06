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

namespace Payman\Application\CreatePaymentPlan;

use Payman\Domain\Model\PaymentPlan\PaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;
use Payman\Domain\Model\PaymentPlan\PaymentPlanRepository;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;
use Payman\Application\ListPaymentPlans\PaymentPlan as PaymentPlanReadModel;

final class CreatePaymentPlanHandler implements CreatePaymentPlanService
{
    private PaymentPlanRepository $repository;

    public function __construct(PaymentPlanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * This method intentionally violates the CQS principle as it returns a read model
     *  of the created payment plan instance.
     */
    public function handle(CreatePaymentPlan $createPaymentPlan): PaymentPlanReadModel
    {
        $id = $this->repository->nextIdentity();
        $name = PaymentPlanName::fromString($createPaymentPlan->name());

        $this->repository->store(
            new PaymentPlan(
                $id,
                $name,
                PaymentPlanType::fromInt($createPaymentPlan->type())
            )
        );

        return new PaymentPlanReadModel($id, $name);
    }
}
