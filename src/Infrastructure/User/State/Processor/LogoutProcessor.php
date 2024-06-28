<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\Application\Message\Command\User\Logout\LogoutCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class is processor for handling user logout operations.
 * It implements the `ProcessorInterface` and uses command bus to handle the `LogoutCommand`.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to send `LogoutCommand` for processing.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the given data to log out user. It creates `LogoutCommand` with the UUID from URI variables, then sends it to command bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: Input data related to the logout operation.
 * - `Operation $operation`: Represents the processing operation.
 * - `array $uriVariables`: Contains the UUID for user to be logged out.
 * - `array $context`: Additional context for the processing operation.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during processing.
 */
final readonly class LogoutProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $bus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->bus->handle(
            new LogoutCommand($uriVariables['uuid'])
        );
    }
}
