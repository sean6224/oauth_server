<?php
declare(strict_types=1);
namespace App\Domain\Shared\Specification\Rule;

use App\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;

/**
 * Interface for defining business rule specifications.
 */
interface BusinessRuleSpecificationInterface
{
    /**
     * Checks if the specification is satisfied.
     *
     * @return bool True if the specification is satisfied, false otherwise.
     */
    public function isSatisfiedBy(): bool;

    /**
     * Gets the validation message when the specification is not satisfied.
     *
     * @return BusinessRuleValidationMessage The validation message.
     */
    public function validationMessage(): BusinessRuleValidationMessage;
}
