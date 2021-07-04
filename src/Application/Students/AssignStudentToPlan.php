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

namespace Payman\Application\Students;

final class AssignStudentToPlan
{
    private string $studentId;

    private string $studentName;

    private string $paymentPlanId;

    public function __construct(
        string $studentId,
        string $studentName,
        string $paymentPlanId
    ) {
        $this->studentId = $studentId;
        $this->studentName = $studentName;
        $this->paymentPlanId = $paymentPlanId;
    }

    public function studentId(): string
    {
        return $this->studentId;
    }

    public function studentName(): string
    {
        return $this->studentName;
    }

    public function paymentPlanId(): string
    {
        return $this->paymentPlanId;
    }
}
