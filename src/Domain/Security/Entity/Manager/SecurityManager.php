<?php
declare(strict_types=1);
namespace App\Domain\Security\Entity\Manager;

use App\Domain\AggregateRootBehaviourTrait;
use App\Domain\Security\Entity\EventsHandler\SecurityHandler;
use App\Domain\Security\Entity\Security;
use App\Domain\Security\Entity\SecurityCode;
use App\Domain\Security\Event\SecurityCodeGenerated;
use App\Domain\Security\Event\SecurityCodeUsed;
use App\Domain\Security\Event\SecurityInvalidateCodes;
use App\Domain\Security\Specification\Checker\CodeSecurityCheckerInterface;
use App\Domain\Security\Specification\Checker\CustomerSecurityCheckerInterface;
use App\Domain\Security\Specification\Rule\CustomerBeenCreatedSecurityCodeRule;
use App\Domain\Shared\Exception\BusinessRuleValidationException;
use App\Domain\Shared\Exception\DateTimeException;
use Ramsey\Uuid\UuidInterface;

/**
 * Manages security-related operations for user entities.
 *
 * Constructor:
 * - `__construct(SecurityHandler $securityHandler)`:
 * Initializes the SecurityManager with the provided security handler.
 *   - Parameters:
 *     - `SecurityHandler $securityHandler`: The handler for managing security-related events.
 *
 * Methods:
 * - `saveCode(UuidInterface $userId, array $code, CustomerSecurityCheckerInterface $customerSecurityCheckerInterface, string $purposeType): Security`: Saves a security code for the user.
 *   - Parameters:
 *     - `UuidInterface $userId`: The UUID of the user for whom the security code is generated.
 *     - `array $code`: An array containing the security code(s) to be saved.
 *     - `CustomerSecurityCheckerInterface $customerSecurityCheckerInterface`: The checker interface to validate security-related rules.
 *     - `string $purposeType`: The purpose type for which the security code is generated.
 *   - Returns:
 *     - `Security`: The security entity associated with the user.
 *   - Throws:
 *     - `DateTimeException`: If there's an issue with date and time operations.
 *     - `BusinessRuleValidationException`: If business rules related to security are violated.
 *
 * - `markCodeAsUsed(SecurityCode $entity,
 * CodeSecurityCheckerInterface $customerCodeSecurityCheckerInterface, string $purposeType):
 * void`:
 * Marks a security code as used.
 *   - Parameters:
 *     - `SecurityCode $entity`: The security code entity to be marked as used.
 *     - `CodeSecurityCheckerInterface $customerCodeSecurityCheckerInterface`:
 * The checker interface to validate the security code usage.
 *     - `String $purposeType`: The purpose type for which the security code is used.
 *
 * - `changeInvalidateCodes(Security $entity): void`: Invalidates all security codes for the given security entity.
 *   - Parameters:
 *     - `Security $entity`: The security entity for which codes are to be invalidated.
 */
class SecurityManager
{
    use AggregateRootBehaviourTrait;

    public function __construct(
        private readonly SecurityHandler $securityHandler
    ) {
    }

    /**
     * @throws DateTimeException
     * @throws BusinessRuleValidationException
     */
    public function saveCode(
        UuidInterface $userId,
        array $code,
        CustomerSecurityCheckerInterface $customerSecurityCheckerInterface,
        string $purposeType
    ): Security
    {
        static::checkRule(
            new CustomerBeenCreatedSecurityCodeRule(
                $customerSecurityCheckerInterface,
                $userId,
                5
            )
        );

        $security = new Security();
        $event = new SecurityCodeGenerated($userId, $code, $purposeType);
        $security->addDomainEvent($event);
        $this->securityHandler->securityCodeGenerated($event, $security);
        return $security;
    }

    public function markCodeAsUsed(
        SecurityCode $entity,
        CodeSecurityCheckerInterface $customerCodeSecurityCheckerInterface,
        string $purposeType
    ): void
    {
       $customerCodeSecurityCheckerInterface->isUsed($entity, $purposeType);

        $event = new SecurityCodeUsed();
        $this->addDomainEvent($event);
        $this->securityHandler->securityCodeUsed($event, $entity);
    }

    public function changeInvalidateCodes(
        Security $entity,
    ): void
    {
        $event = new SecurityInvalidateCodes();
        $this->addDomainEvent($event);
        $this->securityHandler->securityCodeInvalidated($event, $entity);
    }
}
