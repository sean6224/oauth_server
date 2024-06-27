<?php
declare(strict_types=1);
namespace App\Domain;

use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use OutOfBoundsException;
use Ramsey\Uuid\UuidInterface;

/**
 * This trait provides common behavior for aggregate roots, including managing domain events and handling business rule validation.
 *
 * Attributes:
 * - `UuidInterface $uuid`: The unique identifier for the aggregate root.
 * - `array $events`: A list of domain events recorded for the aggregate root.
 *
 * Methods:
 * - `getAggregateRootId()`: Returns the UUID of the aggregate root as string.
 * - `clearDomainEvents()`: Clears the recorded domain events and returns them.
 * - `getUuid()`: Returns the UUID of aggregate root.
 * - `setUuid(UuidInterface $uuid)`: Sets the UUID of aggregate root.
 * - `addDomainEvent(object $event)`: Adds domain event to the list of recorded events.
 * - `getEvents()`: Returns all recorded domain events.
 * - `getEvent(int $index)`: Returns specific domain event by index. Throws `OutOfBoundsException` if the index is out of bounds.
 * - `checkRule(BusinessRuleSpecificationInterface $businessRuleSpecification)`: Checks business rule specification. Throws `BusinessRuleValidationException` if the business rule is not satisfied.
 *
 * Notes:
 * - This trait is designed for use in domain-driven design to add common functionality to aggregate roots.
 * - The trait includes methods for managing domain events, allowing for clear separation of responsibilities in aggregate roots.
 * - The `checkRule` method is used to enforce business rules, ensuring that the aggregate root complies with specified rules.
 */
trait AggregateRootBehaviourTrait
{
    private UuidInterface $uuid;
    private array $events = [];

    public function getAggregateRootId(): string
    {
        return $this->uuid->toString();
    }

    public function clearDomainEvents(): array
    {
        $recordedEvents = $this->events;
        $this->events = [];

        return $recordedEvents;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function addDomainEvent(object $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getEvent(int $index): object
    {
        if (isset($this->events[$index])) {
            return $this->events[$index];
        }

        throw new OutOfBoundsException("Event not found at index $index.");
    }

    /**
     * @throws BusinessRuleValidationException
     */
    protected static function checkRule(BusinessRuleSpecificationInterface $businessRuleSpecification): void
    {
        if ($businessRuleSpecification->isSatisfiedBy()) {
            return;
        }

        throw new BusinessRuleValidationException($businessRuleSpecification);
    }
}
