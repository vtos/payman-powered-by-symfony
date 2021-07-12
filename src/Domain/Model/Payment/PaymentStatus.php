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

namespace Payman\Domain\Model\Payment;

use InvalidArgumentException;

final class PaymentStatus
{
    public const NONE = 1;

    public const ACCEPTED = 2;

    public const APPROVED = 3;

    public const REJECTED = 4;

    private int $option;

    private function __construct(int $statusOption)
    {
        if (!in_array(
            $statusOption,
            [
                self::NONE,
                self::ACCEPTED,
                self::APPROVED,
                self::REJECTED,
            ]
        )) {
            throw new InvalidArgumentException("Invalid payment status option: $statusOption.");
        }
        $this->option = $statusOption;
    }

    public function isNone(): bool
    {
        return $this->option === self::NONE;
    }

    public function isRejected(): bool
    {
        return $this->option === self::REJECTED;
    }

    public function isAccepted(): bool
    {
        return $this->option === self::ACCEPTED;
    }

    public static function none(): self
    {
        return new self(self::NONE);
    }

    public static function accepted(): self
    {
        return new self(self::ACCEPTED);
    }

    public static function approved(): self
    {
        return new self(self::APPROVED);
    }

    public static function rejected(): self
    {
        return new self(self::REJECTED);
    }
}
