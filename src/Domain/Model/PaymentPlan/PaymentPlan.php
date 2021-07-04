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

namespace Payman\Domain\Model\PaymentPlan;

use InvalidArgumentException;

final class PaymentPlan
{
    private PaymentPlanId $id;

    private string $name;

    private PaymentPlanType $type;

    /**
     * @param PaymentPlanId $id
     * @param string $name
     * @param PaymentPlanType $type
     */
    public function __construct(
        PaymentPlanId $id,
        string $name,
        PaymentPlanType $type
    ) {
        if (empty(trim($name)))
        {
            throw new InvalidArgumentException('Name of a payment plan cannot be empty.');
        }
        $this->name = $name;

        $this->id = $id;
        $this->type = $type;
    }

    /**
     * Casts a class object to an array.
     *
     * @return array Each key corresponds to a property name.
     */
    public function asArray(): array
    {
        return [
            'id' => $this->id->asString(),
            'name' => $this->name,
            'type' => $this->type->option(),
        ];
    }
}
