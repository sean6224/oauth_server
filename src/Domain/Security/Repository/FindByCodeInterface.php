<?php
declare(strict_types=1);
namespace App\Domain\Security\Repository;

use App\Domain\Security\Entity\SecurityCode;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface for finding a security code by code and user UUID.
 *
 * Methods:
 * - `findByCode(UuidInterface $userUuid, string $code, string $purposeType): ?SecurityCode`: Finds a security code by its code and associated user UUID.
 *   Returns the security code if found, otherwise returns null.
 */
interface FindByCodeInterface
{
    public function findByCode(UuidInterface $userUuid, string $code): ?SecurityCode;
}
