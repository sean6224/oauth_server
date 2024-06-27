<?php
declare(strict_types=1);
namespace App\Domain\User\Event\Settings;

use App\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents domain event triggered when user is soft-deleted.
 * It contains the unique identifier for the event and the timestamp when the user was soft-deleted.
 *
 * Attributes:
 * - `uuid`: A `UuidInterface` representing the unique identifier for this event and the soft-deleted user.
 * - `deletedAt`: A `DateTime` object indicating when the user was soft-deleted.
 *
 * Constructor:
 * - `__construct(UuidInterface $uuid, DateTime $deletedAt)`: Initializes the event with unique identifier and the soft-deletion timestamp.
 *
 * Notes:
 * - Soft deletion typically means that the user is marked as deleted but not removed from the data store.
 * - This event can be used to trigger additional processes related to soft deletion, such as archiving or hiding user data.
 * - The `UserWasSoftDeleted` class is typically used in event-driven or domain-driven architectures to represent the action of soft-deleting a user.
 */

final class UserWasSoftDeleted
{
    public function __construct(
        public UuidInterface $uuid,
        public DateTime $deletedAt
    ) {}
}
