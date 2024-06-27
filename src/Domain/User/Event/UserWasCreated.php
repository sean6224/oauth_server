<?php
declare(strict_types=1);
namespace App\Domain\User\Event;

use Ramsey\Uuid\UuidInterface;
use App\Domain\User\ValueObject\Username;
use App\Domain\User\ValueObject\Auth\Credentials;

/**
 * Represents an event indicating that user was created.
 */
final class UserWasCreated
{
    public function __construct(
        public UuidInterface $uuid,
        public Username $username,
        public Credentials $credentials,
    ) {}
}
