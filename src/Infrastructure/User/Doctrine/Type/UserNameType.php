<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Domain\User\ValueObject\Username;
use Doctrine\DBAL\Types\ConversionException;
use Throwable;


class UserNameType extends StringType
{
    private const TYPE = 'username';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Username) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Username::class]);
        }

        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof Username) {
            return $value;
        }

        try {
            $email = Username::fromString($value);
        } catch (Throwable) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(),
                $platform->getDateTimeFormatString());
        }

        return $email;
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
