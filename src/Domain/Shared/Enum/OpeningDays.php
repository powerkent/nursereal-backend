<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum OpeningDays: string
{
    case Monday = 'Monday';
    case Tuesday = 'Tuesday';
    case Wednesday = 'Wednesday';
    case Thursday = 'Thursday';
    case Friday = 'Friday';
    case Saturday = 'Saturday';
    case Sunday = 'Sunday';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (OpeningDays $o): string => $o->value, self::cases());
    }

    /**
     * @return list<OpeningDays>
     */
    public static function names(): array
    {
        return array_map(fn (OpeningDays $o): OpeningDays => $o, self::cases());
    }
}
