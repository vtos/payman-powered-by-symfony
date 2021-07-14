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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DoctrineDBALDriverException;
use Doctrine\DBAL\Exception as DoctrineDBALException;
use Payman\Domain\Model\Student\Student;
use Payman\Domain\Model\Student\StudentId;
use Payman\Domain\Model\Student\StudentRepository;

final class StudentRepositoryUsingDBAL implements StudentRepository
{
    private const DB_TABLE = 'payment_plans_students';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws DoctrineDBALException
     */
    public function store(Student $student): void
    {
        $studentRecord = $student->asArray();

        $this->connection->insert(
            self::DB_TABLE,
            [
                'student_id' => $studentRecord['id'],
                'student_name' => $studentRecord['name'],
                'payment_plan_id' => $studentRecord['payment_plan_id'],
            ]
        );
    }

    /**
     * @throws DoctrineDBALException
     */
    public function remove(StudentId $id): void
    {
        $this->connection->delete(
            self::DB_TABLE,
            [
                'student_id' => $id->asString(),
            ]
        );
    }

    /**
     * @throws DoctrineDBALException
     * @throws DoctrineDBALDriverException
     */
    public function studentWithPaymentPlanExists(StudentId $studentId): bool
    {
        $recordsCount = $this->connection->createQueryBuilder()
            ->select('COUNT(*)')
            ->from(self::DB_TABLE)
            ->where('student_id = :student_id')
            ->setParameter(':student_id', $studentId->asString())
            ->execute()
            ->fetchOne();

        return (0 !== (int)$recordsCount);
    }
}
