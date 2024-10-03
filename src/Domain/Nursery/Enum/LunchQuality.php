<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

enum LunchQuality: string
{
    case AteVeryLittle = 'ate_very_little';
    case AteLittle = 'ate_little';
    case AteWell = 'ate_well';
    case AteVeryWell = 'ate_very_well';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (LunchQuality $l): string => $l->value, self::cases());
    }
}
