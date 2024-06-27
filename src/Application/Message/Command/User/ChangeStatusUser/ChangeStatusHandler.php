<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ChangeStatusUser;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\User\Entity\Manager\UserStatusManager;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\UserOperationType;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

/**
 * This class represents command handler for changing user's status.
 * It implements the `CommandHandlerInterface` and uses user repository and `UserStatusManager` to handle status changes.
 *
 * Constructor Parameters:
 * - `UserRepositoryInterface $userRepository`: The repository used to fetch and store user data.
 * - `UserStatusManager $userStatusManager`: Manages user status changes, including suspending, soft-deleting, and restoring users.
 *
 * Method:
 * - `__invoke(ChangeStatusCommand $command)`: Processes the `ChangeStatusCommand` to change user's status. It retrieves the user by UUID, converts the `operationType` string to `UserOperationType`, and changes the user's status accordingly through `UserStatusManager`. The updated user is then stored in repository.
 *
 * Exceptions:
 * - `DateTimeException`: Can be thrown if there are date-time-related issues during the status change process.
 *
 * Notes:
 * - This command handler is designed for command-driven architectures and uses the `UserStatusManager` to manage user status changes.
 * - The `UserOperationType` enum helps ensure valid status changes, minimizing errors.
 */
final readonly class ChangeStatusHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserStatusManager $userStatusManager
    ) {
    }

    /**
     * @throws DateTimeException
     */
    public function __invoke(ChangeStatusCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid());
        $operationType = UserOperationType::from($command->getOperationType());
        $this->userStatusManager->changeStatus($user, $operationType);
        $this->userRepository->store($user);
    }
}
