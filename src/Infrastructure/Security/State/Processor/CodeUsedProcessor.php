<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\Security\CodeUsed\CodeUsedCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class is a processor for used security codes in an API Platform context.
 * It implements the `ProcessorInterface` and uses `CommandBus` to handle the `CodeUsedCommand`.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to dispatch the `CodeUsedCommand`.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the input data to generate security code.
 *   It creates a `CodeUsedCommand` with the necessary parameters and dispatches it through the command bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: The data required to generate security code, typically from an API request.
 * - `Operation $operation`: Represents the operation context.
 * - `array $uriVariables`: Contains the UUID of user for whom the code is generated.
 * - `array $context`: Additional context for the processing operation.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during command handling.
 */
final readonly class CodeUsedProcessor implements ProcessorInterface
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
        $codeUsed = new CodeUsedCommand(
            $uriVariables['uuid'],
            $data->purpose,
            $data->code
        );
        $this->bus->handle($codeUsed);
    }
}
