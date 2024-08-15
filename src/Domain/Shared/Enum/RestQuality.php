<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum RestQuality: string implements SubTypeInterface
{
    case SleptVeryLittle = 'slept_very_little';
    case ProperSleep = 'proper_sleep';
    case SleptWell = 'slept_well';
    case VeryGoodSleep = 'very_good_sleep';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (RestQuality $a): string => $a->value, self::cases());
    }
}
