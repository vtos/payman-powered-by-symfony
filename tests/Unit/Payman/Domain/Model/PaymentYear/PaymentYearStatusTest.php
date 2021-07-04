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

namespace Tests\Unit\Payman\Domain\Model\PaymentYear;

use InvalidArgumentException;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;
use PHPUnit\Framework\TestCase;

final class PaymentYearStatusTest extends TestCase
{
    /**
     * @test
     */
    public function it_cannot_be_instantiated_with_invalid_status_option(): void
    {
        $this->expectException(InvalidArgumentException::class);
        PaymentYearStatus::fromInt(6);
    }
}
