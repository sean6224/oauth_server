<?php
declare(strict_types=1);
namespace App\Domain\Shared\Exception;

use App\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface as BusinessRuleInterface;
use Exception;

final class BusinessRuleValidationException extends Exception
{
    public function __construct(
        private readonly BusinessRuleInterface $businessRuleSpecification
    ) {
        parent::__construct(
            $this->businessRuleSpecification->validationMessage()->message,
            $this->businessRuleSpecification->validationMessage()->code
        );
    }
}
