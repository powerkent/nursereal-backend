<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum CareType: string implements SubTypeInterface
{
    case EyeCare = 'eye_care';
    case NoseCare = 'nose_care';
    case EarCare = 'ear_care';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (CareType $a): string => $a->value, self::cases());
    }
}
