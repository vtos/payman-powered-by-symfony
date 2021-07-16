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

namespace Payman\Application\Students;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\Student\StudentId;

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
        $this->id = $id;
        $this->name = $name;
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
