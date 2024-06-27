<?php
declare(strict_types=1);
namespace App\Domain\User\Event;

use App\Domain\Shared\Event\DomainEventInterface;
use Ramsey\Uuid\UuidInterface;
use App\Domain\User\ValueObject\Email;

/**
 * Represents an event indicating that user has been logged in.
 */
final class UserSignedIn implements DomainEventInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public Email $email
    ) {}
}
