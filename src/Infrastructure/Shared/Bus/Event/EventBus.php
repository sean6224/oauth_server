<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bus\Event;

use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Domain\Shared\Event\DomainEventInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

/**
 * This class represents an event bus responsible for dispatching domain events using Symfony Messenger component.
 *
 * Constructor Parameters:
 * - `MessageBusInterface $messageBus`: The message bus interface used for dispatching domain events.
 *
 * Method:
 * - `handle(DomainEventInterface $event)`: Dispatches domain event using the configured message bus. It catches any `HandlerFailedException` thrown during dispatch and rethrows it using the `MessageBusExceptionTrait`.
 *
 * Notes:
 * - The event bus serves as an abstraction layer for dispatching domain events, allowing for decoupling of event producers and consumers.
 * - It uses the Symfony Messenger component for message dispatching, providing features such as middleware, message routing, and handling.
 * - The `handle` method dispatches a domain event by passing it to the message bus. It catches any `HandlerFailedException` thrown during dispatch and rethrows it using the `MessageBusExceptionTrait`.
 */
final class EventBus
{
    use MessageBusExceptionTrait;

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) { }

    /**
     * @throws Throwable
     */
    public function handle(DomainEventInterface $event): void
    {
        try {
            $this->messageBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
