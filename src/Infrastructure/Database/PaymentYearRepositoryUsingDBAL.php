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
use Doctrine\DBAL\Driver\Exception as DoctrineDBALDriverException;
use Doctrine\DBAL\Exception as DoctrineDBALException;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentYear\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\PaymentYear\PaymentYearRepository;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;

final class PaymentYearRepositoryUsingDBAL implements PaymentYearRepository
{
    private const DB_TABLE = 'payment_years';

    private const IDENTITY_SEQUENCE_TABLE = 'models_id_sequence';

    private const MODEL_NAME = 'payment_year';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DoctrineDBALException
     * @throws DoctrineDBALDriverException
     */
    public function store(PaymentYear $paymentYear): void
    {
        $record = $paymentYear->asArray();

        $recordsWithIdCount = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from(self::DB_TABLE)
            ->where('id = :id')
            ->setParameter(':id', $record['id'])
            ->execute()
            ->fetchOne();

        $recordWithIdExists = (0 !== (int)$recordsWithIdCount);

        if (!$recordWithIdExists) {
            $this->connection->insert(self::DB_TABLE, $record);

            return;
        }

        $this->connection->update(
            self::DB_TABLE,
            $record,
            [
                'id' => $record['id'],
            ]
        );
    }

    public function remove(PaymentYearId $id): void
    {
        // TODO: Implement remove() method.
    }

    public function nextIdentity(): PaymentYearId
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

        return PaymentYearId::fromString(
            (string)$sequence
        );
    }

    /**
     * @inheritDoc
     * @throws DoctrineDBALException
     * @throws DoctrineDBALDriverException
     */
    public function currentPaymentYearExistsInPaymentPlan(PaymentPlanId $paymentPlanId): bool
    {
        $recordsCount = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from(self::DB_TABLE)
            ->where('payment_plan_id = :payment_plan_id AND status = :status')
            ->setParameter(':payment_plan_id', $paymentPlanId->asString())
            ->setParameter(':status', PaymentYearStatus::CURRENT)
            ->execute()
            ->fetchOne();

        return 0 !== (int)$recordsCount;
    }
}
