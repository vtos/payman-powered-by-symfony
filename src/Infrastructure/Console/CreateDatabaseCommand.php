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

namespace Payman\Infrastructure\Console;

use Payman\Infrastructure\Database\SchemaSetup;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateDatabaseCommand extends Command
{
    private SchemaSetup $schemaSetup;

    protected static $defaultName = 'payman:create-database';

    public function __construct(SchemaSetup $schemaSetup, string $name = null)
    {
        $this->schemaSetup = $schemaSetup;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Creates an application database based on schema.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('Creating the database...');

        $this->schemaSetup->dropAndCreateTables();

        $output->writeln(' done.');

        return Command::SUCCESS;
    }
}
