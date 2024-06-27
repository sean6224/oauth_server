<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\SignUp;

use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\Manager\UserManager;
use App\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface as CustomerInterface;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;

/**
 * Command handler for SignUpCommand.
 * Implements CommandHandlerInterface to handle the command.
 *
 * Constructor Parameters:
 * - `UserRepositoryInterface $userRepository`: Repository for storing user entities.
 * - `UserManager $manager`: Manager responsible for user-related operations.
 * - `CustomerInterface $customerEmailUniquenessChecker`: Checker interface for ensuring customer email uniqueness.
 *
 * Methods:
 * - `__construct(UserRepositoryInterface $userRepository, UserManager $manager, CustomerInterface $customerEmailUniquenessChecker)`: Initializes the handler with required dependencies.
 * - `__invoke(SignUpCommand $command)`: Handles the SignUpCommand to create a new user using UserManager and stores it in UserRepository.
 *
 * @throws BusinessRuleValidationException|DateTimeException If there's an issue with business rule validation or date/time operations during user creation.
 */
final readonly class SignUpCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserManager $manager,
        private CustomerInterface $customerEmailUniquenessChecker
    ) {
    }

    /**
     * @throws BusinessRuleValidationException|DateTimeException
     */
    public function __invoke(SignUpCommand $command): void
    {
        $user = $this->manager->create($command->uuid(), $command->username(), $command->credentials(), $this->customerEmailUniquenessChecker);
        $this->userRepository->store($user);
    }
}
