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

namespace Payman\Application\Students;

use RuntimeException;
use Payman\Domain\Model\Student\StudentId;

final class CouldNotFindStudent extends RuntimeException
{
    public static function withId(StudentId $id): self
    {
        return new self(
            sprintf(
                'Student with id %s does not exist.',
                $id->asString()
            )
        );
    }
}
