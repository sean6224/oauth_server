<?php
declare(strict_types=1);
namespace App\Domain\Security\Specification\Rule;

use App\Domain\Security\Specification\Checker\CustomerSecurityCheckerInterface;
use App\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use App\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use Ramsey\Uuid\UuidInterface;

/**
 * Represents business rule specification for ensuring that security codes have been generated uniquely for customer.
 *
 * Attributes:
 * - CustomerSecurityCheckerInterface $securitySpecification: The service used to check if security codes are unique.
 * - UuidInterface $uuid: The UUID of the customer for whom the security codes are checked.
 * - int $limit: The limit of allowed security codes for the customer.
 *
 * Constructor:
 * - __construct(CustomerSecurityCheckerInterface $securitySpecification, UuidInterface $uuid, int $limit): Initializes the specification with the security checker service, customer UUID, and limit.
 *
 * Methods:
 * - isSatisfiedBy(): bool: Checks if the business rule is satisfied by verifying if security codes are unique for the customer.
 * - validationMessage(): BusinessRuleValidationMessage: Provides a validation message when the business rule is not satisfied, indicating that existing codes need to be invalidated before generating new ones.
 *   - Message: "Invalidate codes and only then can you generate new ones"
 *   - Code: 004
 *
 * Notes:
 * - This specification is used to ensure that security codes are generated uniquely for customers, preventing duplication or reuse of codes.
 * - The isSatisfiedBy method uses the CustomerSecurityCheckerInterface to determine if security codes are unique for the specified customer.
 * - The validationMessage method returns a specific message indicating that existing codes should be invalidated before generating new ones.
 */
readonly class CustomerBeenCreatedSecurityCodeRule implements BusinessRuleSpecificationInterface
{
    public function __construct(
        private CustomerSecurityCheckerInterface $securitySpecification,
        private UuidInterface $uuid,
        private int $limit
    ) {}

    /**
     * Check if the business rule is satisfied.
     *
     * @return bool True if the business rule is satisfied, false otherwise.
     */
    public function isSatisfiedBy(): bool
    {
        return $this->securitySpecification->isUnique($this->uuid, $this->limit);
    }

    /**
     * Get the validation message when business rule is not satisfied.
     *
     * @return BusinessRuleValidationMessage The validation message.
     */
    public function validationMessage(): BusinessRuleValidationMessage
    {
        return new BusinessRuleValidationMessage('Invalidate codes and only then can you generate new ones', 004);
    }
}
