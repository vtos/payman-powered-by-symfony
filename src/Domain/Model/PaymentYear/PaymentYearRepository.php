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

namespace Payman\Domain\Model\PaymentYear;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;

interface PaymentYearRepository
{
    public function store(PaymentYear $paymentYear): void;

    public function remove(PaymentYearId $id): void;

    public function nextIdentity(): string;

    /**
     * Enforces singularity of the payment year with a 'current' status within a payment plan.
     *
     * @param PaymentPlanId $paymentPlanId
     * @return bool
     */
    public function currentPaymentYearExistsInPaymentPlanWithId(PaymentPlanId $paymentPlanId): bool;
}
