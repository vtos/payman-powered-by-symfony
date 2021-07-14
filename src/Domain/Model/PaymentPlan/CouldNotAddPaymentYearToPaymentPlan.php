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

namespace Payman\Domain\Model\PaymentPlan;

use RuntimeException;

final class CouldNotAddPaymentYearToPaymentPlan extends RuntimeException
{
    public static function becausePaymentPlanNotExists(PaymentPlanId $id): self
    {
        return new self(
            sprintf(
                'Payment year cannot be added to unknown payment plan with id %s.',
                $id->asString()
            )
        );
    }

    public static function becauseCurrentPaymentYearAlreadyExists(PaymentPlanId $id): self
    {
        return new self(
            sprintf(
                'Payment plan with id %s already contains a year with the \'current\' status.',
                $id->asString()
            )
        );
    }
}
