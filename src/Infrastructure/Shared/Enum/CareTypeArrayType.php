<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Nursery\Domain\Nursery\Enum\CareType;

class CareTypeArrayType extends Type
{
    public const string NAME = 'care_type_array';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'JSON';
    }

    /**
     * @return array<int, CareType>
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): array
    {
        if (null === $value) {
            return [];
        }

        $values = json_decode($value, true);

        return array_map(fn ($val) => CareType::from($val), $values);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string|false|null
    {
        if (empty($value)) {
            return null;
        }

        $arrayValues = array_map(fn (CareType $type) => $type->value, $value);

        return json_encode($arrayValues);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
