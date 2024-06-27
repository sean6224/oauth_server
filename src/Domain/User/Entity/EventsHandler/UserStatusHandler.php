<?php
declare(strict_types=1);
namespace App\Domain\User\Entity\EventsHandler;

use App\Domain\User\Entity\User;
use App\Domain\User\Event\Settings\UserWasRestored;
use App\Domain\User\Event\Settings\UserWasSoftDeleted;
use App\Domain\User\Event\Settings\UserWasSuspended;

/**
 * This class is responsible for handling domain events related to user status changes.
 * It provides methods to apply status changes to `User` entity based on specific domain events.
 *
 * Methods:
 * - `applyUserWasSuspended(UserWasSuspended $event, User $user)`: Applies the `UserWasSuspended` event to `User`, setting the UUID and suspension timestamp.
 * - `applyUserWasSoftDeleted(UserWasSoftDeleted $event, User $user)`: Applies the `UserWasSoftDeleted` event to `User`, setting the UUID and soft-deletion timestamp.
 * - `applyUserWasRestored(UserWasRestored $event, User $user)`: Applies the `UserWasRestored` event to `User`, setting the UUID and clearing the suspension and soft-deletion timestamps.
 *
 * Notes:
 * - The `UserStatusHandler` interacts with `User` entities, updating their attributes based on specific domain events.
 * - Proper handling of these events ensures consistency in user status across the system.
 */
final class UserStatusHandler
{
    public function applyUserWasSuspended(UserWasSuspended $event, User $user): void
    {
        $user->setUuid($event->uuid);
        $user->setSuspendedAt($event->suspendedAt);
    }

    public function applyUserWasSoftDeleted(UserWasSoftDeleted $event, User $user): void
    {
        $user->setUuid($event->uuid);
        $user->setDeletedAt($event->deletedAt);
    }

    public function applyUserWasRestored(UserWasRestored $event, User $user): void
    {
        $user->setUuid($event->uuid);
        $user->setSuspendedAt(null);
        $user->setDeletedAt(null);
    }
}
