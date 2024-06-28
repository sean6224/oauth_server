<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\Doctrine\Type;

use App\Domain\Security\ValueObject\Code;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

/**
 * Custom Doctrine type for handling security code value objects.
 *
 * Attributes:
 * - `TYPE`: Constant representing the name of this custom type.
 *
 * Methods:
 * - `convertToDatabaseValue($value, AbstractPlatform $platform)`: Converts the `Code` value object to its database representation.
 * - `convertToPHPValue($value, AbstractPlatform $platform)`: Converts the database value to `Code` value object.
 * - `requiresSQLCommentHint(AbstractPlatform $platform): bool`: Indicates that this type requires SQL comment hint.
 * - `getName(): string`: Returns the name of this custom type.
 *
 * Notes:
 * - This class handles the conversion of `Code` value objects to and from their database representations, ensuring type safety and validation.
 */
class CodeType extends StringType
{
    private const TYPE = 'code';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Code) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Code::class]);
        }

        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof Code) {
            return $value;
        }

        try {
            $code = Code::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(),
                $platform->getDateTimeFormatString());
        }

        return $code;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName(): string
    {
        return self::TYPE;
    }
}
