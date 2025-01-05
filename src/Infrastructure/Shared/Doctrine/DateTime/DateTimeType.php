<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\DateTime;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType as DoctrineDateTimeType;
use Exception;

class DateTimeType extends DoctrineDateTimeType
{
    public const string DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const string DOCTRINE_DATETIME_FORMAT = 'doctrine_datetime_format';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $value?->format(self::DATETIME_FORMAT);
    }

    /**
     * @throws Exception
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): DateTimeInterface
    {
        if (null === $value || $value instanceof DateTimeInterface) {
            return $value;
        }

        $dateTime = DateTime::createFromFormat(self::DATETIME_FORMAT, $value);

        if (!$dateTime) {
            throw new Exception('Could not convert database value to DateTime');
        }

        return $dateTime;
    }

    public function getName(): string
    {
        return self::DOCTRINE_DATETIME_FORMAT;
    }
}
