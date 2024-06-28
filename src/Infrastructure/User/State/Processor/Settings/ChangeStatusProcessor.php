<?php
declare(strict_types=1);
namespace App\Infrastructure\User\State\Processor\Settings;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Command\User\ChangeStatusUser\ChangeStatusCommand;
use App\Infrastructure\Shared\Bus\Command\CommandBus;
use Throwable;

/**
 * This class is a processor for changing user's status.
 * It implements the `ProcessorInterface` and uses command bus to handle `ChangeStatusCommand`.
 *
 * Constructor Parameters:
 * - `CommandBus $bus`: The command bus used to send `ChangeStatusCommand` for processing.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the given data to change user's status.
 *   It creates `ChangeStatusCommand` with the UUID from the URI variables. security code, and desired status, then sends it to command bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: Input data containing the security code and status for changing user's status.
 * - `Operation $operation`: Represents the processing operation.
 * - `array $uriVariables`: Contains the UUID for the user whose status is being changed.
 * - `array $context`: Context for the processing operation.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during the status change process.
 */
final readonly class ChangeStatusProcessor implements ProcessorInterface
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
            new ChangeStatusCommand(
                $uriVariables['uuid'],
                $data->securityCode,
                $data->status
            )
        );
    }
}
