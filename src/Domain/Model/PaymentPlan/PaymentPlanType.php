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

namespace Payman\Domain\Model\PaymentPlan;

use InvalidArgumentException;

final class PaymentPlanType
{
    public const LOCALS = 1;

    public const FOREIGNERS = 2;

    private int $typeOption;

    private function __construct(int $typeOption)
    {
        if (!in_array($typeOption,
            [
                self::LOCALS,
                self::FOREIGNERS,
            ]
        )) {
            throw new InvalidArgumentException('Invalid option value for payment plan type.');
        }
        $this->typeOption = $typeOption;
    }

    public function option(): int
    {
        return $this->typeOption;
    }

    public static function fromInt(int $typeOption): self
    {
        return new self($typeOption);
    }
}
