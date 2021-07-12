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

namespace Payman\Application\Payments;

final class UploadPayment
{
    private string $studentId;

    private string $paymentYearId;

    private int $amount;

    public function __construct(
        string $studentId,
        string $paymentYearId,
        int $amount
    ) {
        $this->studentId = $studentId;
        $this->paymentYearId = $paymentYearId;
        $this->amount = $amount;
    }

    public function studentId(): string
    {
        return $this->studentId;
    }

    public function paymentYearId(): string
    {
        return $this->paymentYearId;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
