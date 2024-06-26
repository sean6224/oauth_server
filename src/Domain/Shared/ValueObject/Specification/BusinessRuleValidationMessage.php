<?php
declare(strict_types=1);
namespace App\Domain\Shared\ValueObject\Specification;

/**
 * Represents business rule validation message.
 */
final class BusinessRuleValidationMessage
{
    public function __construct(
        public string $message,
        public int $code
    ) {}
}
