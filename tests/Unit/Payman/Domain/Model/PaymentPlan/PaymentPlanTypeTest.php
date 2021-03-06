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

namespace Tests\Unit\Payman\Domain\Model\PaymentPlan;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;

final class PaymentPlanTypeTest extends TestCase
{
    /**
     * @test
     */
    public function it_cannot_be_instantiated_with_invalid_type_option(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PaymentPlanType::fromInt(50);
    }
}
