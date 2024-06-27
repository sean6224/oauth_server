<?php
declare(strict_types=1);
namespace App\Domain\Security\Repository;

use App\Domain\Security\Entity\Security;
use App\Domain\Security\ValueObject\Purpose;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface for finding a non-invalidated security entity by user UUID and purpose.
 *
 * Methods:
 * - `findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose): ?Security`:
 *   Finds a non-invalidated security entity by user UUID and purpose.
 *   Returns the security entity if found, otherwise returns null.
 */
interface FindNonInvalidatedByUserUuidInterface
{
    public function findNonInvalidatedByUserUuid(UuidInterface $userUuid, Purpose $purpose): ?Security;
}
