<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

enum CareType: string implements SubTypeInterface
{
    case EyeCare = 'eye_care';
    case NoseCare = 'nose_care';
    case EarCare = 'ear_care';
    case MouthCare = 'mouth_care';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (CareType $a): string => $a->value, self::cases());
    }
}
