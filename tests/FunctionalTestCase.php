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

namespace Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Payman\Infrastructure\Database\SchemaSetup;

class FunctionalTestCase extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        static::bootKernel([
            'environment' => 'func_test',
            'debug' => true,
        ]);
    }

    protected function setUp(): void
    {
        $schemaSetup = static::$kernel->getContainer()->get(SchemaSetup::class);
        $schemaSetup->dropAndCreateTables();
    }
}
