<?php
declare(strict_types=1);
namespace App\Domain\User\Event\Settings;

use App\Domain\Shared\Event\DomainEventInterface;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

/**
 * This class represents domain event triggered when user's email address is changed.
 * It implements the `DomainEventInterface` to align with domain-driven design patterns.
 *
 * Attributes:
 * - `uuid`: A `UuidInterface` representing the unique identifier for this event.
 * - `email`: An `Email` value object representing the new email address.
 * - `updatedAt`: A `DateTime` object indicating when the email was changed.
 *
 * Constructor:
 * - `__construct(UuidInterface $uuid, Email $email, DateTime $updatedAt)`: Initializes the event with a unique identifier, the new email address, and the timestamp of change.
 *
 * Notes:
 * - This event is typically used in event-driven systems or domain-driven design architectures to signal tha user's email address has been updated.
 * - The `DomainEventInterface` implementation allows this event to integrate with event buses or similar architectures.
 */
final class UserEmailChanged implements DomainEventInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public Email $email,
        public DateTime $updatedAt
    ) {}
}
