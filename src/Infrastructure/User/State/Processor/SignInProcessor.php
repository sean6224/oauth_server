<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\User\SignIn\SignInCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class serves as a processor for user sign-in operations.
 * It implements the `ProcessorInterface` and uses command bus to handle sign-in commands.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to send the `SignInCommand` for processing.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the given data to sign in a user.
 *   - It creates `SignInCommand` using the provided data and sends it to the command bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: Input data containing user credentials, such as email and password.
 * - `Operation $operation`: Represents the processing operation.
 * - `array $uriVariables`: Additional URI variables, if any.
 * - `array $context`: Context for the processing operation.
 *
 * Exceptions:
 * - Throws `Throwable` if there is an error during processing.
 *
 * Notes:
 * - The `process` method creates `SignInCommand` using the provided email and password.
 * - The `CommandBus` is responsible for handling the `SignInCommand`.
 */
final readonly class SignInProcessor implements ProcessorInterface
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
        $signInCommand = new SignInCommand(
            email: $data->email,
            plainPassword: $data->password
        );
        $this->bus->handle($signInCommand);
    }
}
