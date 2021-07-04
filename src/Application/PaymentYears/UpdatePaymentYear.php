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

final class UpdatePaymentYear
{
    private string $id;

    private string $name;

    private string $paymentPlanId;

    private int $cost;

    private int $status;

    private bool $visible;

    public function __construct(
        string $id,
        string $name,
        string $paymentPlanId,
        int $cost,
        int $status,
        bool $visible
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->paymentPlanId = $paymentPlanId;
        $this->cost = $cost;
        $this->status = $status;
        $this->visible = $visible;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function paymentPlanId(): string
    {
        return $this->paymentPlanId;
    }

    public function cost(): int
    {
        return $this->cost;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function visible(): bool
    {
        return $this->visible;
    }
}
