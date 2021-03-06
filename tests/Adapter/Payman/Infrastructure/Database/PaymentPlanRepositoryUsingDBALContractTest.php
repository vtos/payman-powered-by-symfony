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

use Doctrine\DBAL\Connection;
use Payman\Domain\Model\PaymentPlan\PaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;
use Payman\Infrastructure\Database\PaymentPlanRepositoryUsingDBAL;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class PaymentPlanRepositoryUsingDBALContractTest extends KernelTestCase
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

    /**
     * @test
     */
    public function it_stores_a_payment_plan(): void
    {
        $container = self::getContainer();

        $repository = $container->get(PaymentPlanRepositoryUsingDBAL::class);
        $connection = $container->get(Connection::class);

        $paymentPlanId = $repository->nextIdentity();

        $paymentPlan = new PaymentPlan(
            $paymentPlanId,
            PaymentPlanName::fromString('Payment Plan 1'),
            PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
        );

        $repository->store($paymentPlan);

        $paymentPlanRecord = $connection->createQueryBuilder()
            ->select('*')
            ->from('payment_plans')
            ->where('id = :id')
            ->setParameter(':id', $paymentPlanId->asString())
            ->execute()
            ->fetchAssociative();

        $this->assertEquals(
            new PaymentPlan(
                PaymentPlanId::fromString($paymentPlanRecord['id']),
                PaymentPlanName::fromString($paymentPlanRecord['name']),
                PaymentPlanType::fromInt((int)$paymentPlanRecord['type'])
            ),
            $paymentPlan
        );

        // And then update it.
        // TODO: make use of rename() method.
        $paymentPlan = new PaymentPlan(
            $paymentPlanId,
            PaymentPlanName::fromString('Payment Plan 2'),
            PaymentPlanType::fromInt(PaymentPlanType::FOREIGNERS)
        );
        $repository->store($paymentPlan);

        $paymentPlanRecord = $connection->createQueryBuilder()
            ->select('*')
            ->from('payment_plans')
            ->where('id = :id')
            ->setParameter(':id', $paymentPlanId->asString())
            ->execute()
            ->fetchAssociative();

        $this->assertEquals(
            new PaymentPlan(
                PaymentPlanId::fromString($paymentPlanRecord['id']),
                PaymentPlanName::fromString($paymentPlanRecord['name']),
                PaymentPlanType::fromInt((int)$paymentPlanRecord['type'])
            ),
            $paymentPlan
        );
    }

    /**
     * @test
     */
    public function it_removes_a_payment_plan(): void
    {
        $container = self::getContainer();

        $repository = $container->get(PaymentPlanRepositoryUsingDBAL::class);
        $connection = $container->get(Connection::class);

        $paymentPlanId = $repository->nextIdentity();

        $paymentPlan = new PaymentPlan(
            $paymentPlanId,
            PaymentPlanName::fromString('Payment Plan 1'),
            PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
        );

        $repository->store($paymentPlan);

        $repository->remove($paymentPlanId);

        $recordsWithIdCount = $connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from('payment_plans')
            ->where('id = :id')
            ->setParameter(':id', $paymentPlanId->asString())
            ->execute()
            ->fetchOne();

        $this->assertEquals(
            0,
            (int)$recordsWithIdCount
        );
    }
}
