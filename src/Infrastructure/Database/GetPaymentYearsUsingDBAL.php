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
use Payman\Application\PaymentYears\GetPaymentYears;
use Payman\Application\PaymentYears\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\Student\StudentId;

final class GetPaymentYearsUsingDBAL implements GetPaymentYears
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     * @throws DoctrineDBALDriverException
     * @throws DoctrineDBALException
     */
    public function forStudent(StudentId $studentId): array
    {
        $result = $this->connection->createQueryBuilder()
            ->select('y.id, y.name')
            ->from('payment_years', 'y')
            ->innerJoin(
                'y',
                'payment_plans_students',
                's',
                'y.payment_plan_id = s.payment_plan_id'
            )
            ->where('s.student_id = :student_id')
            ->setParameter(':student_id', $studentId->asString())
            ->execute()
            ->fetchAllAssociative();
        if (!$result) {
            return [];
        }

        return array_map(
            function ($row) {
                return new PaymentYear(
                    PaymentYearId::fromString($row['id']),
                    $row['name']
                );
            },
            $result
        );
    }
}
