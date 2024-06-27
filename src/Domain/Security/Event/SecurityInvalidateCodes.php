<?php
declare(strict_types=1);
namespace App\Domain\Security\Event;

use App\Domain\Shared\Event\DomainEventInterface;
use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;

/**
 * Represents the event of security code being invalidated.
 * Implements DomainEventInterface to signal that domain event has occurred.
 *
 * Attributes:
 * - `invalidateAt`: The date and time when the security code was invalidated.
 *
 * Methods:
 * - `__construct()`: Constructs the event with status types. Set the current date and time for `invalidateAt`.
 *
 * Exceptions:
 * - `DateTimeException`: Thrown if there is an error in setting the date and time.
 */
class SecurityInvalidateCodes implements DomainEventInterface
{
    public DateTime $invalidateAt;

    /**
     * @throws DateTimeException
     */
    public function __construct() {
        $this->invalidateAt = DateTime::now();
    }
}
