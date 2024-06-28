<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Specification;

use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\Exception\PurposeNoMatchException;
use App\Domain\Security\Exception\SecurityCodeUsedException;
use App\Domain\Security\Specification\Checker\CodeSecurityCheckerInterface;

/**
 * This class implements the CodeSecurityCheckerInterface for checking if security code is used.
 *
 * Methods:
 * - `isUsed(SecurityCode $entity, string $typeCode)`: Checks if the security code is used for the specified type code.
 *
 * Exceptions:
 * - `PurposeNoMatchException`: Thrown if the purpose of the security code does not match the expected type code.
 * - `SecurityCodeUsedException`: Thrown if the security code has already been used.
 */
readonly class SecurityRootCodeUsedChecker implements CodeSecurityCheckerInterface
{
    public function isUsed(SecurityCode $entity, string $typeCode): bool
    {
        $security = $entity->getSecurity()->getPurposeType();
        if ($security->value() !== $typeCode) {
            throw new PurposeNoMatchException($security, $typeCode);
        }

        if ($entity->isUsed()) {
            throw new SecurityCodeUsedException($entity->getUsedAt());
        }
        return true;
    }
}
