<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Doctrine\Type\Security;

use App\Domain\Security\ValueObject\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

/**
 * Custom Doctrine type for handling security status value objects.
 *
 * Attributes:
 * - `TYPE`: Constant representing the name of this custom type.
 *
 * Methods:
 * - `convertToDatabaseValue($value, AbstractPlatform $platform)`: Converts the `Status` value object to its database representation.
 * - `convertToPHPValue($value, AbstractPlatform $platform)`: Converts the database value to `Status` value object.
 * - `requiresSQLCommentHint(AbstractPlatform $platform): bool`: Indicates that this type requires SQL comment hint.
 * - `getName(): string`: Returns the name of this custom type.
 *
 * Notes:
 * - This class handles the conversion of `Status` value objects to and from their database representations, ensuring type safety and validation.
 */
class StatusType extends StringType
{
    private const TYPE = 'status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Status) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Status::class]);
        }

        return $value->value();
    }


    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof Status) {
            return $value;
        }

        try {
            $code = Status::fromString($value);
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
