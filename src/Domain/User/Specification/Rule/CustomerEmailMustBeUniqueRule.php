<?php
declare(strict_types=1);
namespace App\Domain\User\Specification\Rule;

use App\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use App\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface as CustomerEmailChecker;

/**
 * This class represents business rule that checks if customer email is unique.
 * It verifies whether an email address is already in use, typically to avoid duplicate customer accounts.
 *
 * Attributes:
 * - `uniqueEmailSpecification`: An interface for checking email uniqueness, used to validate the uniqueness of the given email.
 * - `email`: The email address that must be checked for uniqueness.
 *
 * Constructor:
 * - `__construct(CustomerEmailChecker $uniqueEmailSpecification, Email $email)`: Initializes the rule with checker and an email address.
 *
 * Methods:
 * - `isSatisfiedBy()`: Checks if the business rule is satisfied (i.e., if the email is unique). Returns `true` if the rule is satisfied, and `false` otherwise.
 * - `validationMessage()`: Returns `BusinessRuleValidationMessage` with message indicating why the rule is not satisfied. It provides descriptive error message and a corresponding error code.
 *
 * Exception Handling:
 * This class does not throw exceptions but provides validation messages to explain why the rule is not satisfied.
 */
final readonly class CustomerEmailMustBeUniqueRule implements BusinessRuleSpecificationInterface
{
    public function __construct(
        private CustomerEmailChecker $uniqueEmailSpecification,
        private Email $email
    ) {}


    /**
     * Check if the business rule is satisfied.
     *
     * @return bool True if the business rule is satisfied, false otherwise.
     */
    public function isSatisfiedBy(): bool
    {
        return $this->uniqueEmailSpecification->isUnique($this->email);
    }

    /**
     * Get the validation message when business rule is not satisfied.
     *
     * @return BusinessRuleValidationMessage The validation message.
     */
    public function validationMessage(): BusinessRuleValidationMessage
    {
        return new BusinessRuleValidationMessage('Customer with this email already exists', 004);
    }
}
