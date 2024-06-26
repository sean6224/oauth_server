<?php
declare(strict_types=1);
namespace App\Domain\Shared\ValueObject;

use Webmozart\Assert\Assert;

use function password_hash;
use function password_verify;

abstract class HashString
{
    public const DEFAULT_COST = 12;
    private int $cost;
    private string $hashedValue;

    private function __construct(string $hashedValue, int $cost)
    {
        $this->hashedValue = $hashedValue;
        $this->cost = $cost;
    }

    public static function encode(string $plainValue, int $cost = self::DEFAULT_COST): static
    {
        return new static(self::hash($plainValue, $cost), $cost);
    }

    public static function fromHash(string $hashedValue, int $cost = self::DEFAULT_COST): static
    {
        return new static($hashedValue, $cost);
    }

    public function match(string $plainValue): bool
    {
        return password_verify($plainValue, $this->hashedValue);
    }

    private static function hash(string $plainValue, int $cost): string
    {
        Assert::minLength($plainValue, 6, 'Min 6 characters');

        /** @var string|null $hashedValue */
        $hashedValue = password_hash($plainValue, PASSWORD_BCRYPT, ['cost' =>  $cost]);

        return (string)$hashedValue;
    }

    public function toString(): string
    {
        return $this->hashedValue;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function __toString(): string
    {
        return $this->hashedValue;
    }
}
