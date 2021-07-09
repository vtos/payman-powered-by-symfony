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

namespace Payman\Application\PaymentPlans;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;

/**
 * This is a read model for payment plans. It can be used to retrieve the required info about a payment plan: name,
 * cost of the current year, etc.
 */
final class PaymentPlan
{
    private PaymentPlanId $id;

    private PaymentPlanName $name;

    public function __construct(PaymentPlanId $id, PaymentPlanName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id->asString(),
            'name' => $this->name->asString(),
        ];
    }
}
