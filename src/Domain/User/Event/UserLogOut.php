<?php
declare(strict_types=1);
namespace App\Domain\User\Event;

use App\Domain\Shared\Event\DomainEventInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Represents an event indicating that user has been logged out.
 */
final class UserLogOut implements DomainEventInterface
{
    public function __construct(
        public UuidInterface $uuid
    ) {}
}
