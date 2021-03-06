<?php
/**
 * This file is part of the vtos/payment application.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright 2021 Vitaly Potenko <potenkov@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 * @link https://github.com/vtos/payman GitHub
 */

declare(strict_types=1);

namespace Payman\Application\PaymentYears;

use Payman\Domain\Model\PaymentYear\PaymentYearId;
use Payman\Domain\Model\PaymentYear\PaymentYearRepository;

final class RemovePaymentYearHandler
{
    private PaymentYearRepository $repository;

    public function __construct(PaymentYearRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(RemovePaymentYear $command): void
    {
        $this->repository->remove(
            PaymentYearId::fromString($command->id())
        );
    }
}