<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Specification;

use App\Domain\Security\Exception\SecurityCodeLimitException;
use App\Domain\Security\Repository\CheckUserSecurityByUuidInterface;
use App\Domain\Security\Specification\Checker\CustomerSecurityCheckerInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Represents a customer security checker implementing the CustomerSecurityCheckerInterface.
 *
 * This class checks if security code limit exists for user based on their UUID.
 *
 * Methods:
 * - isUnique(UuidInterface $uuid, int $limit): bool
 *   - Checks if a security code limit exists for the user with the specified UUID.
 *
 * Parameters:
 *   - UuidInterface $uuid: The UUID of the user for whom to check the security code limit.
 *   - int $limit: The security code limit to be checked.
 *
 * Returns:
 *   - bool: True if security code limit exists for the user, false otherwise.
 *
 * Exceptions:
 *   - SecurityCodeLimitException: Thrown if security code limit exists for the user.
 *
 * Notes:
 * - This class implements the CustomerSecurityCheckerInterface and uses the CheckUserSecurityByUuidInterface to perform the security check.
 */
readonly class CustomerSecurityChecker implements CustomerSecurityCheckerInterface
{
    public function __construct(
        private CheckUserSecurityByUuidInterface $checkUserByUuid
    ) {}

    public function isUnique(UuidInterface $uuid, int $limit): bool
    {
        if ($this->checkUserByUuid->securityCodeLimitExists($uuid, $limit)) {
            throw new SecurityCodeLimitException();
        }

        return true;
    }
}
