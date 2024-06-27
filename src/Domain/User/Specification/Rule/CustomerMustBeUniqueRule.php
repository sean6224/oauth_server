<?php
declare(strict_types=1);
namespace App\Domain\User\Specification\Rule;

use App\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use App\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use App\Domain\User\Specification\Checker\CustomerUniquenessCheckerInterface as CustomerInterface;
use Ramsey\Uuid\UuidInterface;
use App\Domain\User\ValueObject\Auth\Credentials;

/**
 * Business rule specification for ensuring customer uniqueness.
 */
final readonly class CustomerMustBeUniqueRule implements BusinessRuleSpecificationInterface
{
    public function __construct(
        private CustomerInterface $customerUniquenessChecker,
        private UuidInterface $uuid,
        private Credentials $credentials
    ) {}

    /**
     * Check if the business rule is satisfied.
     *
     * @return bool True if the business rule is satisfied, false otherwise.
     */
    public function isSatisfiedBy(): bool
    {
        return $this->customerUniquenessChecker->isUnique($this->uuid, $this->credentials);
    }

    /**
     * Get the validation message when business rule is not satisfied.
     *
     * @return BusinessRuleValidationMessage The validation message.
     */
    public function validationMessage(): BusinessRuleValidationMessage
    {
        return new BusinessRuleValidationMessage('Customer already exists', 044);
    }
}
