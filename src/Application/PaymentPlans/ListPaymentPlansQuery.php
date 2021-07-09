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

final class ListPaymentPlansQuery
{
    private PaymentPlans $paymentPlans;

    public function __construct(PaymentPlans $paymentPlans)
    {
        $this->paymentPlans = $paymentPlans;
    }

    /**
     * @return array See {@link PaymentPlans::list()}.
     */
    public function query(): array
    {
        return $this->paymentPlans->list();
    }
}
