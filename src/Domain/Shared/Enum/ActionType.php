<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

use function array_map;

enum ActionType: string
{
    case Activity = 'activity';
    case Care = 'care';
    case Rest = 'rest';
    case Treatment = 'treatment';
    case Other = 'other';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (ActionType $a): string => $a->value, self::cases());
    }
}
