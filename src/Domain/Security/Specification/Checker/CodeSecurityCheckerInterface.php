<?php
declare(strict_types=1);
namespace App\Domain\Security\Specification\Checker;

use App\Domain\Security\Entity\SecurityCode;

/**
 * Interface for checking the usage status of security codes.
 *
 * Methods:
 * - `isUsed(SecurityCode $entity, string $typeCode)`: Checks if a security code has been used.
 *
 * Attributes:
 * - `$entity`: The security code entity to check.
 * - `$typeCode`: The type of security code.
 */
interface CodeSecurityCheckerInterface
{
    public function isUsed(SecurityCode $entity, string $typeCode): bool;
}
