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

namespace Payman\Application\UpdatePaymentPlan;

/**
 * A point of contact between the application infrastructure and the application domain - a command (a DTO object),
 * accepting primitive-typed data and transferring it to the domain.
 */
final class UpdatePaymentPlan
{
    private string $id;

    private string $name;

    private int $type;

    public function __construct(string $id, string $name, int $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): int
    {
        return $this->type;
    }
}
