<?php
declare(strict_types=1);
namespace App\Domain\Security\Specification\Checker;

use Ramsey\Uuid\UuidInterface;

/**
 * Represents an interface for checking the uniqueness of security codes for customer.
 *
 * Methods:
 * - isUnique(UuidInterface $uuid, int $count): bool: Checks if security codes are unique for the specified customer.
 *   - Parameters:
 *     - UuidInterface $uuid: The UUID of the customer for whom to check the uniqueness of security codes.
 *     - int $limit: The limit of security codes to be checked for uniqueness.
 *   - Returns:
 *     - bool: True if the security codes are unique for the customer, false otherwise.
 *
 * Notes:
 * - This interface defines method for verifying if security codes are unique for specific customer based on their UUID and limit of security codes to be checked.
 */
interface CustomerSecurityCheckerInterface
{
    public function isUnique(UuidInterface $uuid, int $limit): bool;
}
