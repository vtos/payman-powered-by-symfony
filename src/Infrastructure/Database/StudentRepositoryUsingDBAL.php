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

use Payman\Domain\Model\Student\Student;
use Payman\Domain\Model\Student\StudentId;
use Payman\Domain\Model\Student\StudentRepository;

final class StudentRepositoryUsingDBAL implements StudentRepository
{

    public function store(Student $student): void
    {
        // TODO: Implement store() method.
    }

    public function remove(StudentId $id): void
    {
        // TODO: Implement remove() method.
    }
}
