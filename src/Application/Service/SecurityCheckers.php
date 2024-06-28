<?php
declare(strict_types=1);
namespace App\Application\Service;

use App\Domain\Security\Specification\Checker\CodeSecurityCheckerInterface;
use App\Domain\Security\Specification\Checker\CustomerSecurityCheckerInterface;

/**
 * This service class aggregates security checkers for user-related operations.
 *
 * Attributes:
 * - `customerSecurityChecker`: An interface for checking customer security rules.
 * - `customerSecurityCodeChecker`: An interface for checking security code rules.
 *
 * Methods:
 * - `getCustomerSecurityChecker()`: Returns the customer security checker interface.
 * - `getCodeSecurityChecker()`: Returns the code security checker interface.
 */
final readonly class SecurityCheckers
{
    public function __construct(
        private CustomerSecurityCheckerInterface $customerSecurityChecker,
        private CodeSecurityCheckerInterface $customerSecurityCodeChecker,
    ) { }

    public function getCustomerSecurityChecker(): CustomerSecurityCheckerInterface
    {
        return $this->customerSecurityChecker;
    }

    public function getCodeSecurityChecker(): CodeSecurityCheckerInterface
    {
        return $this->customerSecurityCodeChecker;
    }
}
