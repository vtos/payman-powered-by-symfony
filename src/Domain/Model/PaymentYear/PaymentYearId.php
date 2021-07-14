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

namespace Payman\Domain\Model\PaymentYear;

use InvalidArgumentException;

final class PaymentYearId
{
    private string $id;

    private function __construct(string $id)
    {
        if (empty(trim($id)))
        {
            throw new InvalidArgumentException('Payment year id cannot be empty.');
        }
        $this->id = $id;
    }

    public function asString(): string
    {
        return $this->id;
    }

    public static function fromString(string $str): self
    {
        return new self($str);
    }
}
