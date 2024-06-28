<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor\Security;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\UseCase\Command\User\ResetPassword\ResetPasswordCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * Represents a processor for resetting user password security.
 *
 * This processor is responsible for handling the resetting of user's password security.
 *
 * Methods:
 * - __construct(CommandBus $bus): Constructor to initialize the processor with command bus.
 *   - Parameters:
 *     - CommandBus $bus: The command bus for handling the reset password command.
 *
 * - process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void: Method to process the reset password operation.
 *   - Parameters:
 *     - mixed $data: The data associated with reset password operation.
 *     - Operation $operation: The operation being processed.
 *     - array $uriVariables: The URI variables associated with the operation.
 *     - array $context: The context associated with the operation.
 *   - Throws:
 *     - Throwable: If an error occurs while handling the reset password command.
 */
final readonly class ResetPasswordProcessor implements ProcessorInterface
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
            new ResetPasswordCommand($data->email, $data->codeSecurity)
        );
    }
}
