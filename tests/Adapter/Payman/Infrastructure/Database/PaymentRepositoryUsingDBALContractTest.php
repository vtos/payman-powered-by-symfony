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

namespace Tests\Adapter\Payman\Infrastructure\Database;

use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Infrastructure\Database\PaymentPlanRepositoryUsingDBAL;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class PaymentRepositoryUsingDBALContractTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(
            [
                'debug' => true,
            ]
        );
    }

    /**
     * @test
     */
    public function it_provides_next_identity(): void
    {
        $container = self::getContainer();

        $repository = $container->get(PaymentPlanRepositoryUsingDBAL::class);

        $this->assertEquals(
            PaymentPlanId::fromString('1'),
            $repository->nextIdentity()
        );
        $this->assertEquals(
            PaymentPlanId::fromString('2'),
            $repository->nextIdentity()
        );
        $this->assertEquals(
            PaymentPlanId::fromString('3'),
            $repository->nextIdentity()
        );
    }
}
