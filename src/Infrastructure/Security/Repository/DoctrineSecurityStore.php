<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Repository;

use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\Repository\SecurityRepositoryInterface;
use App\Infrastructure\Shared\Repository\AbstractMysqlRepository;

/**
 * Represents Doctrine implementation of the SecurityRepositoryInterface.
 * This repository is responsible for storing security entities in MySQL database.
 *
 * Methods:
 * - `saveSecurity(Security $entitySecurity)`: Method to save security entity.
 *   - Parameters:
 *     - `Security $entitySecurity`: The security entity to be stored.
 *   - Returns: void
 * - `saveSecurityCode(Security $entityCode)`: Method to save security entity.
 *    - Parameters:
 *      - `SecurityCode $entityCode`: The security code entity to be stored.
 *    - Returns: void
 *
 * Notes:
 * - This class extends the AbstractMysqlRepository class.
 * - It provides an implementation for storing security entities in MySQL database.
 */
class DoctrineSecurityStore extends AbstractMysqlRepository implements SecurityRepositoryInterface
{
    protected function getClass(): string
    {
        return Security::class;
    }

    /**
     * saveSecurity (persist) given Security to repository.
     *
     * @param Security $entitySecurity
     */
    public function saveSecurity(Security $entitySecurity): void
    {
        $this->save($entitySecurity);
        $this->apply();
    }

    public function saveSecurityCode(SecurityCode $entityCode): void
    {
        $this->save($entityCode);
        $this->apply();
    }
}
