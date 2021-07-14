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
use Doctrine\DBAL\Schema\Schema;

final class SchemaSetup
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function dropAndCreateTables(): void
    {
        $schema = new Schema();

        $paymentPlansTable = $schema->createTable('payment_plans');
        $paymentPlansTable->addColumn('id', 'bigint', ['unsigned' => true]);
        $paymentPlansTable->addColumn('name', 'string', ['length' => 255]);
        $paymentPlansTable->addColumn('type', 'smallint', ['unsigned' => true]);

        $paymentPlansTable->setPrimaryKey(
            [
                'id',
            ]
        );

        $paymentYearsTable = $schema->createTable('payment_years');
        $paymentYearsTable->addColumn('id', 'bigint', ['unsigned' => true]);
        $paymentYearsTable->addColumn('name', 'string', ['length' => 255]);
        $paymentYearsTable->addColumn('payment_plan_id', 'bigint', ['unsigned' => true]);
        $paymentYearsTable->addColumn('cost', 'smallint', ['unsigned' => true]);
        $paymentYearsTable->addColumn('status', 'smallint', ['unsigned' => true]);
        $paymentYearsTable->addColumn('visible', 'smallint', ['unsigned' => true]);

        $paymentYearsTable->setPrimaryKey(
            [
                'id',
            ]
        );
        $paymentYearsTable->addIndex(
            [
                'payment_plan_id'
            ],
            'payment_plan_id'
        );

        $studentsAssignmentTable = $schema->createTable('payment_plans_students');
        $studentsAssignmentTable->addColumn('student_id', 'string', ['length' => 255]);
        $studentsAssignmentTable->addColumn('student_name', 'string', ['length' => 255]);
        $studentsAssignmentTable->addColumn('payment_plan_id', 'bigint', ['unsigned' => true]);

        $studentsAssignmentTable->addForeignKeyConstraint(
            'payment_plans',
            [
                'payment_plan_id'
            ],
            [
                'id',
            ]
        );
        $studentsAssignmentTable->addUniqueIndex(
            [
                'student_id',
            ],
            'student_id'
        );
        $studentsAssignmentTable->addUniqueIndex(
            [
                'student_id',
                'payment_plan_id',
            ],
            'student_payment_plan'
        );

        $modelsIdentitySequence = $schema->createTable('models_id_sequence');
        $modelsIdentitySequence->addColumn('model', 'string', ['length' => 100]);
        $modelsIdentitySequence->addColumn('seq', 'bigint', ['unsigned' => true]);
        $modelsIdentitySequence->addUniqueIndex(
            [
                'model'
            ]
        );

        $schemaManager = $this->connection->getSchemaManager();
        $schemaManager->dropAndCreateTable($paymentPlansTable);
        $schemaManager->dropAndCreateTable($paymentYearsTable);
        $schemaManager->dropAndCreateTable($modelsIdentitySequence);
        $schemaManager->dropAndCreateTable($studentsAssignmentTable);
    }
}
