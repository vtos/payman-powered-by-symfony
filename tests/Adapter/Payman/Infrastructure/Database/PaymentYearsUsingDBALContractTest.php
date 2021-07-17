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

namespace Tests\Adapter\Payman\Infrastructure\Database;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Payman\Domain\Model\PaymentPlan\PaymentPlanName;
use Payman\Domain\Model\PaymentPlan\PaymentPlanType;
use Payman\Domain\Model\PaymentYear\Cost;
use Payman\Domain\Model\PaymentYear\PaymentYear;
use Payman\Domain\Model\PaymentYear\PaymentYearStatus;
use Payman\Domain\Model\Student\Student;
use Payman\Domain\Model\Student\StudentId;
use Payman\Domain\Model\PaymentPlan\PaymentPlan;
use Payman\Application\PaymentYears\PaymentYear as StudentPaymentYear;
use Payman\Infrastructure\Database\GetPaymentYearsUsingDBAL;
use Payman\Infrastructure\Database\PaymentPlanRepositoryUsingDBAL;
use Payman\Infrastructure\Database\PaymentYearRepositoryUsingDBAL;
use Payman\Infrastructure\Database\StudentRepositoryUsingDBAL;

final class PaymentYearsUsingDBALContractTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel(
            [
                'debug' => true,
            ]
        );
    }

    /**
     * @test
     */
    public function it_fetches_payment_years_fro_student(): void
    {
        // Init required services.
        $container = self::getContainer();
        $getPaymentYears = $container->get(GetPaymentYearsUsingDBAL::class);
        $paymentYearRepository = $container->get(PaymentYearRepositoryUsingDBAL::class);
        $paymentPlanRepository = $container->get(PaymentPlanRepositoryUsingDBAL::class);
        $studentRepository = $container->get(StudentRepositoryUsingDBAL::class);

        // Create several payment years first.
        $paymentPlanId = $paymentPlanRepository->nextIdentity();
        $paymentPlanRepository->store(
            new PaymentPlan(
                $paymentPlanId,
                PaymentPlanName::fromString('Payment Plan 1'),
                PaymentPlanType::fromInt(PaymentPlanType::LOCALS)
            )
        );

        $studentId = StudentId::fromString('1');
        $studentRepository->store(
            new Student(
                $studentId,
                'John Doe',
                $paymentPlanId
            )
        );

        $paymentYearId[] = $paymentYearRepository->nextIdentity();
        $paymentYearRepository->store(
            new PaymentYear(
                $paymentYearId[0],
                '2020-2021',
                $paymentPlanId,
                Cost::fromInt(50000),
                PaymentYearStatus::fromInt(PaymentYearStatus::CURRENT),
                true
            )
        );
        $paymentYearId[] = $paymentYearRepository->nextIdentity();
        $paymentYearRepository->store(
            new PaymentYear(
                $paymentYearId[1],
                '2021-2022',
                $paymentPlanId,
                Cost::fromInt(55000),
                PaymentYearStatus::fromInt(PaymentYearStatus::UPCOMING),
                false
            )
        );

        // Test it out.
        $this->assertEquals(
            [
                new StudentPaymentYear($paymentYearId[0], '2020-2021'),
                new StudentPaymentYear($paymentYearId[1], '2021-2022'),
            ],
            $getPaymentYears->forStudent($studentId)
        );
    }
}
