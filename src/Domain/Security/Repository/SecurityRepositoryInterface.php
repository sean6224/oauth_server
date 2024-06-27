<?php
declare(strict_types=1);
namespace App\Domain\Security\Repository;

use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;

/**
 * Represents an interface for storing security entities.
 *
 * Methods:
 * - `saveSecurity(Security $entitySecurity)`: Method to save security entity.
 *   - Parameters:
 *     - `Security $entitySecurity`: The security entity to be stored.
 *   - Returns: void
 * - `saveSecurityCode(Security $securityEntity)`: Method to save security code entity.
 *    - Parameters:
 *      - `SecurityCode $entityCode`: The security entity to be stored.
 *    - Returns: void
 *
 * Notes:
 * - This interface defines a method for storing security entities in a repository.
 */
interface SecurityRepositoryInterface
{
    public function saveSecurity(Security $entitySecurity): void;

    public function saveSecurityCode(SecurityCode $entityCode): void;
}
