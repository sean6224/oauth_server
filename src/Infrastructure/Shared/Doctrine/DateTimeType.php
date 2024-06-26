<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Doctrine;


use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class DateTimeType extends DateTimeImmutableType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof DateTime) {
            return $value->format($platform->getDateTimeFormatString());
        }

        if ($value instanceof DateTimeImmutable) {
            return $value->format($platform->getDateTimeFormatString());
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', DateTime::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof DateTime) {
            return $value;
        }

        try {
            $dateTime = DateTime::fromString($value);
        } catch (DateTimeException) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(),
                $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }

    public function getName(): string
    {
        return Types::DATETIME_IMMUTABLE;
    }
}
