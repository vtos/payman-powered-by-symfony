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

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentYear\Cost;
use Payman\Domain\Model\PaymentYear\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\PaymentYear\PaymentYearRepository;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;

final class UpdatePaymentYearHandler
{
    private PaymentYearRepository $repository;

    public function __construct(PaymentYearRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(UpdatePaymentYear $command): void
    {
        $this->repository->store(
            new PaymentYear(
                PaymentYearId::fromString($command->id()),
                $command->name(),
                PaymentPlanId::fromString($command->paymentPlanId()),
                Cost::fromInt($command->cost()),
                PaymentYearStatus::fromInt($command->status()),
                $command->visible()
            )
        );
    }
}
