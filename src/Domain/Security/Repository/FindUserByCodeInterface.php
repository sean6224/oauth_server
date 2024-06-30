<?php
declare(strict_types=1);
namespace App\Domain\Security\Repository;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface for finding user by security code.
 *
 * Methods:
 * - `findUserBySecurity(string $code, string $purpose): ?UuidInterface`: Finds security code by its code and purpose.
 *   Returns the user UUID if found and invalidateAt is null, otherwise returns null.
 */
interface FindUserByCodeInterface
{
    public function findUserBySecurity(string $code, string $purpose): ?UuidInterface;
}
