<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\User\SignUp\SignUpCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class serves as a processor for user sign-up operations.
 * It implements the `ProcessorInterface` and uses command bus to handle sign-up commands.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to send the `SignUpCommand` for processing.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the given data to sign up new user.
 *   - It creates `SignUpCommand` with the provided information and sends it to the command bus for handling.
 *
 * Parameters for `process`:
 * - `mixed $data`: Input data containing user details, such as email, username, and password.
 * - `Operation $operation`: Represents the processing operation.
 * - `array $uriVariables`: Additional URI variables, if any.
 * - `array $context`: Context for the processing operation.
 *
 * Exceptions:
 * - Throws `Throwable` if an error occurs during processing.
 *
 * Notes:
 * - The `process` method creates `SignUpCommand` with the given user details.
 * - The `CommandBus` handles the `SignUpCommand`.
 * - This processor can be integrated with frameworks, like API Platform, for user sign-up operations.
 */
final readonly class SignUpProcessor implements ProcessorInterface
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
        $userDTO = new SignUpCommand(
            email: $data->email,
            username: $data->username,
            plainPassword: $data->password
        );
        $this->bus->handle($userDTO);
    }
}
