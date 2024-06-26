<?php
declare(strict_types=1);
namespace App\Domain\Shared\ValueObject;

abstract class BoolValue
{
    protected bool $value;

    protected function __construct(bool $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): static
    {
        $normalizedValue = strnatcasecmp($value, 'true') === 0 ||
            strnatcasecmp($value, 'yes') === 0 ||
            strnatcasecmp($value, '1') === 0;

        return new static($normalizedValue);
    }

    public static function fromBool(bool $value): static
    {
        return new static($value);
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }
}
