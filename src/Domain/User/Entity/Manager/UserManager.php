<?php
declare(strict_types=1);
namespace App\Domain\User\Entity\Manager;

use App\Domain\AggregateRootBehaviourTrait;
use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\User\Entity\EventsHandler\UserHandler;
use App\Domain\User\Entity\User;
use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Event\UserSignedIn;
use App\Domain\User\Event\UserLogOut;
use App\Domain\User\Event\Settings\UserEmailChanged;
use App\Domain\User\Event\Settings\UserPasswordChanged;
use App\Domain\User\Exception\InvalidCredentialsException;
use App\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use App\Domain\User\Specification\Rule\CustomerEmailMustBeUniqueRule;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\HashedPassword;
use App\Domain\User\ValueObject\Username;
use Ramsey\Uuid\UuidInterface;

/**
 * This class is responsible for managing user-related operations.
 * It includes methods for creating a user, signing in, logging out, and changing email, among other tasks.
 * It uses the `AggregateRootBehaviourTrait` to handle domain events and other aggregate root behaviors.
 *
 * Constructor Parameters:
 * - `UserHandler $userHandler`: A handler for processing domain events related to user operations.
 *
 * Methods:
 * - `create(UuidInterface $uuid, Username $username, Credentials $credentials,
 * CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker)`:
 * Creates a new user and triggers the `UserWasCreated` domain event after checking the email's uniqueness.
 * Throw `BusinessRuleValidationException` or `DateTimeException` if there's an issue.
 * - `signIn(User $user, string $plainPassword)`: Signs in the user if the password matches.
 * Throw `InvalidCredentialsException` if the credentials are invalid.
 * Triggers the `UserSignedIn` domain event.
 * - `logOut(User $user)`: Logs out the user and triggers the `UserLogOut` domain event.
 * - `changeEmail(User $user, Email $email, CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker)`:
 * Changes the user's email after checking its uniqueness.
 * Throw `DateTimeException` if there's a date-time-related issue.
 * Triggers the `UserEmailChanged` domain event.
 * - `changePassword(User $user, HashedPassword $password)`: Changes the user's password.
 * Throw `DateTimeException` if there's a date-time-related issue.
 * Triggers the `UserPasswordChanged` domain event.
 */
class UserManager
{
    use AggregateRootBehaviourTrait;

    public function __construct(
        private readonly UserHandler $userHandler
    ) {
    }

    /**
     * @throws BusinessRuleValidationException|DateTimeException
     */
    public function create(
        UuidInterface $uuid,
        Username $username,
        Credentials $credentials,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ): User
    {
        static::checkRule(new CustomerEmailMustBeUniqueRule($customerEmailUniquenessChecker, $credentials->email));

        $user = new User();
        $event = new UserWasCreated($uuid, $username, $credentials);
        $user->addDomainEvent($event);
        $this->userHandler->userWasCreated($event, $user);
        return $user;
    }

    /**
     * @throws DateTimeException
     */
    public function signIn(User $user, string $plainPassword): void
    {
        if (!$user->getPassword()->match($plainPassword)) {
            throw new InvalidCredentialsException('Invalid credentials entered.');
        }

        $event = new UserSignedIn($user->getUuid(), $user->getEmail());
        $user->addDomainEvent($event);
        $this->userHandler->userSignedIn($event, $user);
    }

    public function logOut(User $user): void
    {
        $event = new UserLogOut($user->getUuid());
        $this->addDomainEvent($event);
        $this->userHandler->logOut($event, $user);
    }

    /**
     * @throws DateTimeException
     */
    public function changeEmail(
        User $user,
        Email $email,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ): void
    {
        $customerEmailUniquenessChecker->isUnique($email);
        $event = new UserEmailChanged($user->getUuid(), $email, DateTime::now());
        $this->addDomainEvent($event);
        $this->userHandler->userEmailChanged($event, $user);
    }


    /**
     * @throws DateTimeException
     */
    public function changePassword(
        User $user,
        HashedPassword $password,
    ): void
    {
        $event = new UserPasswordChanged($user->getUuid(), $password, DateTime::now());
        $this->addDomainEvent($event);
        $this->userHandler->UserPasswordChanged($event, $user);
    }
}
