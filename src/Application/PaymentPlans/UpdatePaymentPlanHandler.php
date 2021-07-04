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

namespace Payman\Application\PaymentPlans;

use Payman\Domain\Model\PaymentPlan\PaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanRepository;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;

final class UpdatePaymentPlanHandler
{
    private PaymentPlanRepository $repository;

    public function __construct(PaymentPlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UpdatePaymentPlan $command): void
    {
        $this->repository->store(
            new PaymentPlan(
                PaymentPlanId::fromString($command->id()),
                $command->name(),
                PaymentPlanType::fromInt($command->type())
            )
        );
    }
}
