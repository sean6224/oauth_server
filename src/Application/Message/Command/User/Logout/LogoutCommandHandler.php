<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\Logout;

use App\Domain\User\Entity\Manager\UserManager;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

/**
 * This class is a command handler for processing the `LogoutCommand`.
 * It implements the `CommandHandlerInterface` and uses user repository and `UserManager` to log out user.
 *
 * Constructor Parameters:
 * - `UserRepositoryInterface $userRepository`: The repository used to fetch and store user data.
 * - `UserManager $userManager`: Manages user-related operations, including logging out.
 *
 * Method:
 * - `__invoke(LogoutCommand $command)`: Processes the `LogoutCommand` to log out user. It retrieves the user by UUID, logs them out through the `UserManager`, and then stores the updated user in the repository.
 *
 * Notes:
 * - The `UserManager` is used to manage the logout process, ensuring consistency in user-related operations.
 * - The user repository is used to retrieve the user and store updated information after logout.
 */
final readonly class LogoutCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserManager $userManager
    ) {
    }

    public function __invoke(LogoutCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid());
        $this->userManager->logOut($user);
        $this->userRepository->store($user);
    }
}
