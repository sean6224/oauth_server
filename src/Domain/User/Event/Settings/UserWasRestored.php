<?php
declare(strict_types=1);
namespace App\Domain\User\Event\Settings;

use Ramsey\Uuid\UuidInterface;

/**
 * This class represents domain event triggered when user is restored.
 * It captures the unique identifier for the event, indicating which user has been restored.
 *
 * Attributes:
 * - `uuid`: A `UuidInterface` representing the unique identifier for the event and restored user.
 *
 * Constructor:
 * - `__construct(UuidInterface $uuid)`: Initializes the event with unique identifier for restored user.
 *
 * Notes:
 * - This event can be used in event-driven or domain-driven systems to signal that user has been restored, typically from suspended or soft-deleted state.
 * - The `UserWasRestored` class may trigger additional processes, such as reactivating user-related data or re-enabling user access.
 */
class UserWasRestored
{
    public function __construct(
        public UuidInterface $uuid
    ) {}
}
