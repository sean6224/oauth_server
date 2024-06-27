<?php
declare(strict_types=1);
namespace App\Domain;

use App\Domain\Shared\Event\DomainEventInterface;

/**
 * Interface for aggregate root entities.
 */
interface AggregateRootInterface
{
    /**
     * Returns unique identifier of the aggregate root.
     *
     * @return string The aggregate root identifier.
     */
    public function getAggregateRootId(): string;

    /**
     * Clears domain events accumulated by the aggregate root.
     *
     * @return array|DomainEventInterface[] The cleared domain events.
     */
    public function clearDomainEvents(): array;
}

