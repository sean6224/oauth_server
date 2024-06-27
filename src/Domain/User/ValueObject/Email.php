<?php
declare(strict_types=1);
namespace App\Domain\User\ValueObject;

use App\Domain\Shared\ValueObject\StringValue;
use Webmozart\Assert\Assert;

class Email extends StringValue
{
    public static function fromString(string $value): static
    {
        Assert::email($value, 'Not a valid email');
        return new self($value);
    }
}
