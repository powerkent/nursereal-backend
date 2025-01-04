<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

use function array_map;

enum ClockingInState: string
{
    case InProgress = 'in_progress';
    case Done = 'done';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (ClockingInState $c): string => $c->value, self::cases());
    }
}
