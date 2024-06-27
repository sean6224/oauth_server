<?php
declare(strict_types=1);
namespace App\Domain\User\Entity\Manager;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\User\Entity\EventsHandler\UserStatusHandler;
use App\Domain\User\Entity\User;
use App\Domain\User\Event\Settings\UserWasRestored;
use App\Domain\User\Event\Settings\UserWasSoftDeleted;
use App\Domain\User\Event\Settings\UserWasSuspended;
use App\Domain\User\Exception\UserAlreadySoftDeletedException;
use App\Domain\User\Exception\UserAlreadySuspendedException;
use App\Domain\User\Exception\UserCannotBeRestoredException;
use App\Domain\User\UserOperationType;

/**
 * This class is responsible for managing user statuses, including suspending, soft-deleting, and restoring users.
 * It uses `UserStatusHandler` to apply domain events related to status changes.
 *
 * Constructor Parameters:
 * - `UserStatusHandler $statusEventsHandler`: A handler for processing domain events related to user status changes.
 *
 * Methods:
 * - `changeStatus(User $user, UserOperationType $operationType)`: Changes the status of a user based on the provided operation type. It throws appropriate exceptions if the user cannot be changed to desired status.
 * - `suspendUser(User $user)`: Suspends a user and triggers the `UserWasSuspended` domain event. Throws `UserAlreadySuspendedException` if the user is already suspended.
 * - `softDeleteUser(User $user)`: Soft-deletes a user and triggers the `UserWasSoftDeleted` domain event. Throws `UserAlreadySoftDeletedException` if the user is already soft-deleted.
 * - `restoreUser(User $user)`: Restores user from suspended or soft-deleted state and triggers the `UserWasRestored` domain event. Throws `UserCannotBeRestoredException` if the user cannot be restored.
 *
 * Exceptions:
 * - `UserAlreadySuspendedException`: Thrown if an attempt is made to suspend an already suspended user.
 * - `UserAlreadySoftDeletedException`: Thrown if an attempt is made to soft-delete an already soft-deleted user.
 * - `UserCannotBeRestoredException`: Thrown if the user is not in state that allows restoration.
 * - `DateTimeException`: Thrown if there is an issue with date-time operations during status changes.
 */
readonly class UserStatusManager
{
    public function __construct(
        private UserStatusHandler $statusEventsHandler
    ) {
    }

    /**
     * @throws UserAlreadySuspendedException
     * @throws UserAlreadySoftDeletedException|DateTimeException
     */
    public function changeStatus(User $user, UserOperationType $operationType): void
    {
        if ($operationType === UserOperationType::SUSPEND && !$user->isSuspended()) {
            $this->suspendUser($user);
        } elseif ($operationType === UserOperationType::SOFT_DELETE && !$user->isDeleted()) {
            $this->softDeleteUser($user);
        } elseif ($operationType === UserOperationType::RESTORE && ( $user->isSuspended() || $user->isDeleted() )) {
            $this->restoreUser($user);
        }
    }

    /**
     * @throws UserAlreadySuspendedException|DateTimeException
     */
    public function suspendUser(User $user): void
    {
        if ($user->isSuspended()) {
            throw new UserAlreadySuspendedException();
        }

        $event = new UserWasSuspended($user->getUuid(), DateTime::now());
        $user->addDomainEvent($event);
        $this->statusEventsHandler->applyUserWasSuspended($event, $user);
    }

    /**
     * @throws DateTimeException
     */
    public function softDeleteUser(User $user): void
    {
        if ($user->isDeleted()) {
            throw new UserAlreadySoftDeletedException();
        }
        $event = new UserWasSoftDeleted($user->getUuid(), DateTime::now());
        $user->addDomainEvent($event);
        $this->statusEventsHandler->applyUserWasSoftDeleted($event, $user);
    }

    public function restoreUser(User $user): void
    {
        if (!$user->isSuspended() && !$user->isDeleted()) {
            throw new UserCannotBeRestoredException();
        }

        $event = new UserWasRestored($user->getUuid());
        $user->addDomainEvent($event);
        $this->statusEventsHandler->applyUserWasRestored($event, $user);
    }
}
