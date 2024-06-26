<?php
/** @noinspection ALL */
declare(strict_types=1);
namespace App\Infrastructure\Shared\Bridge\Doctrine;

use App\Domain\AggregateRootInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

/**
 * This class is Doctrine event subscriber designed to collect domain events from aggregate roots during various lifecycle events.
 * It implements `EventSubscriber` and listens to Doctrine events such as prePersist, preUpdate, preRemove, preFlush, and postFlush.
 *
 * Constructor:
 * - `DomainEventCollector()`: Initializes an empty collection to store aggregate roots with domain events.
 *
 * Methods:
 * - `prePersist(PrePersistEventArgs $args)`: Collects the domain events from object being persisted.
 * - `preUpdate(PreUpdateEventArgs $args)`: Collects the domain events from object being updated.
 * - `preRemove(PreRemoveEventArgs $args)`: Collects the domain events from object being removed.
 * - `preFlush(PreFlushEventArgs $args)`: Collects domain events from all objects in the identity map.
 * - `postFlush(PostFlushEventArgs $args)`: Placeholder for post-flush logic (no operation by default).
 * - `collect(object $entity)`: Collects domain events from aggregate roots if they are not already in the collection.
 * - `getSubscribedEvents()`: Returns the list of events to which this subscriber is subscribed.
 * - `getEntities()`: Returns the collection of entities with domain events.
 *
 * Notes:
 * - This class is designed to work with Doctrine's ORM to collect domain events during various lifecycle events.
 * - The `collect` method checks if an object is an instance of `AggregateRootInterface` and adds it to the collection if not already present.
 * - The `getSubscribedEvents` method returns the list of Doctrine events that trigger this subscriber.
 */
final class DomainEventCollector implements EventSubscriber
{
    private ArrayCollection $entities;

    public function __construct()
    {
        $this->entities = new ArrayCollection();
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->collect($args->getObject());
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->collect($args->getObject());
    }

    public function preRemove(PreRemoveEventArgs $args): void
    {
        $this->collect($args->getObject());
    }

    public function preFlush(PreFlushEventArgs $args): void
    {
        $unitOfWork = $args->getObjectManager()->getUnitOfWork();
        foreach ($unitOfWork->getIdentityMap() as $entities) {
            foreach ($entities as $entity) {
                $this->collect($entity);
            }
        }
    }

    public function PostFlush(PostFlushEventArgs $args): void
    {
        $this->entities->clear();
    }

    private function collect(object $entity): void
    {
        if ($entity instanceof AggregateRootInterface && !$this->entities->contains($entity)) {
            $this->entities->add($entity);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
            Events::preFlush,
            Events::postFlush
        ];
    }

    public function getEntities(): ArrayCollection
    {
        return $this->entities;
    }
}
