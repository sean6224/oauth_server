<?php
declare(strict_types=1);
namespace App\Domain\User\Specification\Checker;

use App\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface for checking customer uniqueness.
 */
interface CustomerUniquenessCheckerInterface
{
    /**
     * Checks if the provided UUID and email are unique.
     *
     * @param UuidInterface $uuid The UUID to check for uniqueness.
     * @param Credentials $credentials The credentials containing the email to check for uniqueness.
     * @return bool True if the UUID and email are unique, false otherwise.
     */
    public function isUnique(UuidInterface $uuid, Credentials $credentials): bool;
}
