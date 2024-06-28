<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor\Settings;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\User\ChangeEmail\ChangeEmailCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class serves as a processor for changing user's email address.
 * It implements the `ProcessorInterface` and uses command bus to handle the `ChangeEmailCommand`.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to send the `ChangeEmailCommand` for processing.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the given data to change user's email address.
 *   It creates `ChangeEmailCommand` with the user UUID and new email address, then sends it to the command bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: Input data containing the user UUID and new email address.
 * - `Operation $operation`: Represents the processing operation.
 * - `array $uriVariables`: Additional URI variables, if any.
 * - `array $context`: Context for the processing operation.
 *
 * Notes:
 * - This processor handles the logic for changing a user's email address in a command-driven architecture.
 * - The `CommandBus` is used to process the `ChangeEmailCommand`, allowing for separation of concerns and improved scalability.
 */
final readonly class ChangeEmailProcessor implements ProcessorInterface
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
        $changeEmail = new ChangeEmailCommand(
            userUuid: $uriVariables['uuid'],
            email: $data->email
        );
        $this->bus->handle($changeEmail);
    }
}
