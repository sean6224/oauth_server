<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ChangeEmail;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\User\Entity\Manager\UserManager;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface as CustomerEmail;

/**
 * This class represents command handler for changing user's email address.
 * It processes the `ChangeEmailCommand` implementing `CommandHandlerInterface`.
 *
 * Constructor Parameters:
 * - `UserRepositoryInterface $userRepository`: The repository used to fetch and store user data.
 * - `CustomerEmail $uniqueEmailSpecification`: A specification checker to ensure the email being changed to is unique.
 * - `UserManager $userManager`: Manages user-related operations, including changing email.
 *
 * Method:
 * - `__invoke(ChangeEmailCommand $command)`: Processes the `ChangeEmailCommand` to change user's email address.
 *   It retrieves the user by UUID, changes the user's email after checking its uniqueness, and then stores updated user in repository.
 *
 * Exceptions:
 * - `DateTimeException`: Can be thrown if there are date-time-related issues during the email change process.
 *
 * Notes:
 * - The `CustomerEmailUniquenessCheckerInterface` is used to ensure the new email address is unique.
 * - The `UserManager` helps coordinate user-related operations, providing a level of abstraction for user management tasks.
 */
final readonly class ChangeEmailCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CustomerEmail $uniqueEmailSpecification,
        private UserManager $userManager
    ) {
    }

    /**
     * @throws DateTimeException
     */
    public function __invoke(ChangeEmailCommand $command): void
    {
        $user = $this->userRepository->get($command->userUuid());
        $this->userManager->changeEmail($user, $command->email(), $this->uniqueEmailSpecification);
        $this->userRepository->store($user);
    }
}
