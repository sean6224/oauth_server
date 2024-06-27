<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\SignIn;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\User\Exception\InvalidCredentialsException;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Repository\GetUserUuidByEmailInterface;
use App\Domain\User\Entity\Manager\UserManager;
use Doctrine\ORM\NonUniqueResultException;

/**
 * This class handles the `SignInCommand` to sign in user.
 * It implements the `CommandHandlerInterface` and uses repository interfaces to retrieve user data.
 *
 * Constructor Parameters:
 * - `UserRepositoryInterface $userStore`: A repository for storing and retrieving user data.
 * - `GetUserUuidByEmailInterface $userUuidRepository`: An interface to get user UUID by their email address.
 *
 * Methods:
 * - `__invoke(SignInCommand $command)`: Processes the `SignInCommand` to authenticate the user. It retrieves the user UUID by email, checks for null,
 *  - and if a valid UUID is found, it retrieves the user, checks the password, and stores the updated user. If the UUID is null, it throws an `InvalidCredentialsException`.
 *
 * Exceptions:
 * - `InvalidCredentialsException`: Thrown if the UUID is null, indicating invalid email or password.
 * - `NonUniqueResultException`: Thrown if there are multiple results when retrieving the user UUID by email.
 *
 * Notes:
 * - This class is intended to process user sign-in commands in command-driven architecture.
 * - The `__invoke` method serves as the command handler for the sign-in process.
 * - Exception handling is built in to ensure proper error reporting when credentials are invalid or when multiple results are found.
 */
final readonly class SignInCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userStore,
        private GetUserUuidByEmailInterface $userUuidRepository,
        private UserManager $manager,
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws DateTimeException
     */
    public function __invoke(SignInCommand $command): void
    {
        $uuid = $this->userUuidRepository->getUuidByEmail($command->email());
        if (null === $uuid) {
            throw new InvalidCredentialsException();
        }

        $user = $this->userStore->get($uuid);
        $this->manager->signIn($user, $command->plainPassword());
        $this->userStore->store($user);
    }
}
