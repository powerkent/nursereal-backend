<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum Gender: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Unknown = 'Unknown';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (Gender $g): string => $g->value, self::cases());
    }
}
