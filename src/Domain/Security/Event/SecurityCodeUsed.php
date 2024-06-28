<?php
declare(strict_types=1);
namespace App\Domain\Security\Event;

use App\Domain\Security\ValueObject\Status;
use App\Domain\Shared\Event\DomainEventInterface;
use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;

/**
 * Represents the event of security code being used.
 * Implements DomainEventInterface to signal that domain event has occurred.
 *
 * Attributes:
 * - `status`: The status for which the security code was used.
 * - `usedAt`: The date and time when the security code was used.
 *
 * Methods:
 * - `__construct()`: Constructs the event with status types. Set the current date and time for `usedAt`.
 *
 * Exceptions:
 * - `DateTimeException`: Thrown if there is an error in setting the date and time.
 */
final class SecurityCodeUsed implements DomainEventInterface
{
    public Status $status;
    public DateTime $usedAt;

    /**
     * @throws DateTimeException
     */
    public function __construct(
    ) {
        $this->status = Status::fromString('used');
        $this->usedAt = DateTime::now();
    }
}
