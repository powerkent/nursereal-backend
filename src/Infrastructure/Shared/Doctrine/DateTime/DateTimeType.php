<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\DateTime;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType as DoctrineDateTimeType;

class DateTimeType extends DoctrineDateTimeType
{
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const DOCTRINE_DATETIME_FORMAT = 'doctrine_datetime_format';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): DateTimeInterface
    {
        return $value?->format(self::DATETIME_FORMAT);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): DateTimeInterface
    {
        if (null === $value || $value instanceof DateTimeInterface) {
            return $value;
        }

        $dateTime = \DateTime::createFromFormat(self::DATETIME_FORMAT, $value);

        if (!$dateTime) {
            throw new \Exception('Could not convert database value to DateTime');
        }

        return $dateTime;
    }

    public function getName(): string
    {
        return self::DOCTRINE_DATETIME_FORMAT;
    }
}
