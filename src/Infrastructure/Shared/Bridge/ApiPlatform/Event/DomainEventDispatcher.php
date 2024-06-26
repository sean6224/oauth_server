<?php
/** @noinspection ALL */
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bridge\ApiPlatform\Event;

use App\Infrastructure\Shared\Bridge\Doctrine\DomainEventCollector;
use App\Infrastructure\Shared\Bus\Event\EventBus;
use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

/**
 * This class is an event subscriber for dispatching domain events upon application or console termination.
 * It implements `EventSubscriberInterface` and uses a `DomainEventCollector` to gather events and an `EventBus` to dispatch them.
 *
 * Constructor Parameters:
 * - `DomainEventCollector $collector`: Collects domain events from various sources.
 * - `EventBus $eventBus`: Dispatches domain events to the appropriate handlers.
 *
 * Methods:
 * - `onKernelTerminate(TerminateEvent $event)`: Handles Symfony's `KernelEvents::TERMINATE`, dispatching domain events when the HTTP kernel terminates.
 * - `onConsoleTerminate(ConsoleTerminateEvent $event)`: Handles Symfony's `ConsoleEvents::TERMINATE`, dispatching domain events when a console command terminates.
 * - `dispatch()`: Dispatches collected domain events through the `EventBus`. Throws `Throwable` if an error occurs during event dispatching.
 * - `getSubscribedEvents()`: Returns the Symfony events to which this subscriber is subscribed.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during event dispatching.
 *
 * Notes:
 * - This class listens to termination events from both HTTP and console contexts, ensuring that domain events are dispatched when the application is closing.
 * - The `dispatch` method collects domain events from the `DomainEventCollector` and dispatches them through the `EventBus`.
 * - The `MessageBusExceptionTrait` is used to handle exceptions during event dispatching, extracting the root cause from `HandlerFailedException`.
 */
final class DomainEventDispatcher implements EventSubscriberInterface
{
    use MessageBusExceptionTrait;

    public function __construct(
        private readonly DomainEventCollector $collector,
        private readonly EventBus $eventBus
    ) {}

    /**
     * @throws Throwable
     */
    public function onKernelTerminate(TerminateEvent $event): void
    {
        $this->dispatch();
    }

    /**
     * @throws Throwable
     */
    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        $this->dispatch();
    }

    /**
     * @throws Throwable
     */
    private function dispatch(): void
    {
        $entities = $this->collector->getEntities();

        if($entities->isEmpty()) {
            return;
        }

        foreach ($entities as $entity) {
            foreach ($entity->clearDomainEvents() as $domainEvent) {
                $this->eventBus->handle($domainEvent);
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::TERMINATE => 'onKernelTerminate',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }
}
