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

namespace Payman\Application\PaymentYears;

use Payman\Domain\Model\PaymentYear\PaymentYearId;

final class PaymentYear
{
    private PaymentYearId $id;

    private string $name;

    public function __construct(PaymentYearId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->id->asString();
    }

    public function name(): string
    {
        return $this->name;
    }
}
