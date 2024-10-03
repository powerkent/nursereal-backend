<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

use function array_map;

enum ActionState: string
{
    case NewAction = 'new_action';
    case ActionInProgress = 'action_in_progress';
    case ActionDone = 'action_done';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (ActionState $a): string => $a->value, self::cases());
    }
}
