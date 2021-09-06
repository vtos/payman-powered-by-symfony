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

use Doctrine\DBAL\Exception as DoctrineDBALException;
use Doctrine\DBAL\Connection;
use Payman\Application\ListPaymentPlans\PaymentPlan;
use Payman\Application\ListPaymentPlans\PaymentPlans;
use Payman\Domain\Model\PaymentPlan\PaymentPlanId;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;

final class PaymentPlansUsingDBAL implements PaymentPlans
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     * @throws DoctrineDBALException
     */
    public function list(): array
    {
        $records = $this->connection->fetchAllAssociative(
            'SELECT * FROM payment_plans'
        );

        return array_map(
            function($record) {
                return new PaymentPlan(
                    PaymentPlanId::fromString($record['id']),
                    PaymentPlanName::fromString($record['name'])
                );
            },
            $records
        );
    }
}
