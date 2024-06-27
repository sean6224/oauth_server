<?php
declare(strict_types=1);
namespace App\Domain\Security\Repository;

use Ramsey\Uuid\UuidInterface;

/**
 * Represents an interface for checking user security code limits by UUID.
 *
 * Methods:
 * - securityCodeLimitExists(UuidInterface $uuid, int $limit): bool: Checks if security code limit exists for the user with the specified UUID.
 *   - Parameters:
 *     - UuidInterface $uuid: The UUID of the user for whom to check the security code limit.
 *     - int $limit: The security code limit to be checked.
 *   - Returns:
 *     - bool: True if security code limit exists for the user, false otherwise.
 *
 * Notes:
 * - This interface defines method for verifying if security code limit exists for user based on their UUID and specified limit.
 */
interface CheckUserSecurityByUuidInterface
{
    public function securityCodeLimitExists(UuidInterface $uuid, int $limit): bool;
}
