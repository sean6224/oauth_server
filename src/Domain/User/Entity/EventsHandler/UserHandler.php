<?php
declare(strict_types=1);
namespace App\Domain\User\Entity\EventsHandler;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\User\Entity\User;
use App\Domain\User\Event\Settings\UserEmailChanged;
use App\Domain\User\Event\UserLogOut;
use App\Domain\User\Event\UserSignedIn;
use App\Domain\User\Event\UserWasCreated;
use Webmozart\Assert\Assert;

/**
 * This class is responsible for handling domain events related to user entities.
 * It provides methods to apply specific domain events to `User` entity, such as user creation, sign-in, logout, and email change.
 *
 * Methods:
 * - `userWasCreated(UserWasCreated $event, User $user)`: Applies the `UserWasCreated` event, setting UUID, username, credentials, and creation timestamp.
 * - `userSignedIn(UserSignedIn $event, User $user)`: Applies the `UserSignedIn` event, updating user's UUID, email, and login timestamp. Throw `DateTimeException` if there's a date-time-related issue.
 * - `logOut(UserLogOut $event, User $user)`: Applies the `UserLogOut` event, setting the UUID and logging out the user. Displays message indicating the user has logged out.
 * - `userEmailChanged(UserEmailChanged $event, User $user)`: Applies the `UserEmailChanged` event, validating that the new email is different from the current one and updating the email and other related attributes. Use `Webmozart\Assert\Assert` for validation.
 *
 * Notes:
 * - Proper handling of these domain events ensures consistency in user management across the system.
 * - The class uses the `DateTime` value object to manage timestamps and relies on assertions to validate business rules.
 */
class UserHandler
{
    /**
     * @throws DateTimeException
     */
    public function userWasCreated(UserWasCreated $event, User $user): void
    {
        $user->setUuid($event->uuid);
        $user->setUsername($event->username);
        $user->setEmail($event->credentials->getEmail());
        $user->setPassword($event->credentials->getPassword());
        $user->setCreatedAt(DateTime::now());
    }

    /**
     * @throws DateTimeException
     */
    public function userSignedIn(UserSignedIn $event, User $user): void
    {
        $user->setUuid($event->uuid);
        $user->setUpdatedAt(DateTime::now());
        $user->setLoggedAt(DateTime::now());
        $user->setEmail($event->email);
    }

    public function logOut(UserLogOut $event, User $user): void
    {
        $user->setUuid($event->uuid);
    }

    public function userEmailChanged(UserEmailChanged $event, User $user): void
    {
        Assert::notEq(
            $user->email->value(),
            $event->email->value(),
            'New email should be different'
        );

        $user->setEmail($event->email);
        $user->setUpdatedAt($event->updatedAt);
    }
}
