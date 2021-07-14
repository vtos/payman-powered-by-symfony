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

namespace Payman\Domain\Model\Student;

use InvalidArgumentException;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;

final class Student
{
    private StudentId $id;

    private string $name;

    private PaymentPlanId $paymentPlanId;

    public function __construct(
        StudentId $id,
        string $name,
        PaymentPlanId $paymentPlanId
    ) {
        if (empty(trim($name)))
        {
            throw new InvalidArgumentException('Student name cannot be empty.');
        }
        $this->name = $name;

        $this->id = $id;
        $this->paymentPlanId = $paymentPlanId;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id->asString(),
            'name' => $this->name,
            'payment_plan_id' => $this->paymentPlanId->asString(),
        ];
    }
}
