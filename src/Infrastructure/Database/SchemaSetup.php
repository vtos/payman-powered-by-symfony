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
                'id'
            ]
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
        $schemaManager->dropAndCreateTable($modelsIdentitySequence);
    }
}
