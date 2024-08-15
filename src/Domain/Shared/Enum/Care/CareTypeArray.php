<?php

declare(strict_types=1);

namespace App\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Nursery\Domain\Shared\Enum\CareType;

class CareTypeArray extends Type
{
    public const NAME = 'care_type_array';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'JSON'; // Le type SQL pour stocker du JSON
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return [];
        }

        $values = json_decode($value, true); // Décoder le JSON en tableau

        return array_map(fn ($val) => CareType::from($val), $values); // Convertir chaque valeur en énumération CareType
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        $arrayValues = array_map(fn (CareType $type) => $type->value, $value); // Convertir chaque CareType en chaîne

        return json_encode($arrayValues); // Encoder en JSON
    }

    public function getName()
    {
        return self::NAME;
    }
}
