<?php
declare(strict_types=1);
namespace App\Domain\User\Event\Settings;

use App\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents domain event triggered when user is suspended.
 * It captures information about the event, such as the unique identifier and timestamp when user was suspended.
 *
 * Attributes:
 * - `uuid`: A `UuidInterface` representing the unique identifier for this event and the suspended user.
 * - `suspendedAt`: A `DateTime` object indicating when the user was suspended.
 *
 * Constructor:
 * - `__construct(UuidInterface $uuid, DateTime $suspendedAt)`: Initializes the event with unique identifier and the suspension timestamp.
 *
 * Notes:
 * - This event is typically used in event-driven systems or domain-driven design to signal that user has been suspended.
 * - It is intended to represent the action of suspending user and can be used to trigger additional processes related to suspension.
 */
final class UserWasSuspended
{
    public function __construct(
        public UuidInterface $uuid,
        public DateTime $suspendedAt
    ) {}
}
