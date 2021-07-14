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

namespace Payman\Domain\Model\Student;

use RuntimeException;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;

final class CouldNotAssignStudentToPaymentPlan extends RuntimeException
{
    public static function becausePaymentPlanNotExistsWithId(PaymentPlanId $id): self
    {
        return new self('Payment plan with id ' . $id->asString() . ' does not exist.');
    }

    public static function becauseAlreadyAssigned(StudentId $studentId): self
    {
        return new self(
            sprintf(
                'Student with id %s is already assigned to a payment plan.',
                $studentId->asString()
            )
        );
    }
}
