<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\Security\InvalidateCode\InvalidateCodeCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * Represents a processor for invalid user code security.
 *
 * This processor is responsible for handling the invalid of user's code security.
 *
 * Methods:
 * - __construct(CommandBus $bus): Constructor to initialize the processor with command bus.
 *   - Parameters:
 *     - CommandBus $bus: The command bus for handling the invalid password command.
 *
 * - process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void: Method to process the reset password operation.
 *   - Parameters:
 *     - mixed $data: The data associated with invalid security code user operation.
 *     - Operation $operation: The operation being processed.
 *     - array $uriVariables: The URI variables associated with the operation.
 *     - array $context: The context associated with the operation.
 *   - Throws:
 *     - Throwable: If an error occurs while handling the invalid security code command.
 */
readonly class InvalidCodeProcessor implements ProcessorInterface
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
            new InvalidateCodeCommand(
                $uriVariables['uuid'],
                $data->purpose
            )
        );
    }
}
