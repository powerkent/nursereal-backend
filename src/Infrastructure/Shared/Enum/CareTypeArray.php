<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Nursery\Domain\Nursery\Enum\CareType;

class CareTypeArray extends Type
{
    public const NAME = 'care_type_array';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSON';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return [];
        }

        $values = json_decode($value, true);

        return array_map(fn ($val) => CareType::from($val), $values);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        $arrayValues = array_map(fn (CareType $type) => $type->value, $value);

        return json_encode($arrayValues);
    }

    public function getName()
    {
        return self::NAME;
    }
}
