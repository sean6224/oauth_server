<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bus\Command;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final readonly class CommandBus
{
    public function __construct(
        private MessageBusInterface $messageBus
    ) {}

    /** @throws Throwable */
    public function handle(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious() ?? $e;
        }
    }
}
