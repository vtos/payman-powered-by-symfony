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

namespace Payman\Infrastructure\Database;

use Exception;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DoctrineDBALException;
use Doctrine\DBAL\Driver\Exception as DoctrineDBALDriverException;
use Payman\Domain\Model\PaymentPlan\PaymentPlan;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanRepository;

final class PaymentPlanRepositoryUsingDBAL implements PaymentPlanRepository
{
    private const MODEL_TABLE = 'payment_plans';

    private const IDENTITY_SEQUENCE_TABLE = 'models_id_sequence';

    private const MODEL_NAME = 'payment_plan';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DoctrineDBALException
     * @throws DoctrineDBALDriverException
     */
    public function store(PaymentPlan $plan): void
    {
        $record = $plan->asArray();

        $recordsWithIdCount = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from(self::MODEL_TABLE)
            ->where('id = :id')
            ->setParameter(':id', $record['id'])
            ->execute()
            ->fetchOne();

        $recordWithIdExists = (0 !== (int)$recordsWithIdCount);

        if (!$recordWithIdExists) {
            $this->connection->insert(self::MODEL_TABLE, $record);

            return;
        }

        $this->connection->update(
            self::MODEL_TABLE,
            $record,
            [
                'id' => $record['id'],
            ]
        );
    }

    /**
     * @throws DoctrineDBALException
     */
    public function remove(PaymentPlanId $id): void
    {
        $this->connection->delete(
            self::MODEL_TABLE,
            [
                'id' => $id->asString(),
            ]
        );
    }

    /**
     * @throws DoctrineDBALException
     * @throws DoctrineDBALDriverException
     */
    public function nextIdentity(): PaymentPlanId
    {
        $this->connection->beginTransaction();

        try {
            $sequence = $this->connection->createQueryBuilder()
                ->select('seq')
                ->from(self::IDENTITY_SEQUENCE_TABLE)
                ->where('model = :model')
                ->setParameter(':model', self::MODEL_NAME)
                ->execute()
                ->fetchOne();
            if (false === $sequence) {
                $sequence = 1;

                $this->connection->insert(
                    self::IDENTITY_SEQUENCE_TABLE,
                    [
                        'model' => self::MODEL_NAME,
                        'seq' => 2,
                    ]
                );
            } else {
                $this->connection->update(
                    self::IDENTITY_SEQUENCE_TABLE,
                    [
                        'seq' => $sequence + 1,
                    ],
                    [
                        'model' => self::MODEL_NAME,
                    ]
                );
            }

            $this->connection->commit();
        } catch (Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }

        return PaymentPlanId::fromString(
            (string)$sequence
        );
    }

    public function paymentPlanExists(PaymentPlanId $id): bool
    {
        $recordsWithIdCount = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from(self::MODEL_TABLE)
            ->where('id = :id')
            ->setParameter(':id', $id->asString())
            ->execute()
            ->fetchOne();

        return (0 !== (int)$recordsWithIdCount);
    }
}
