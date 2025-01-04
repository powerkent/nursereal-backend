<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

use function array_map;

enum ActionType: string implements SubTypeActionInterface
{
    case Action = 'action';
    case Activity = 'activity';
    case Care = 'care';
    case Diaper = 'diaper';
    case Rest = 'rest';
    case Treatment = 'treatment';
    case Presence = 'presence';
    case Lunch = 'lunch';
    case Milk = 'milk';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (ActionType $a): string => $a->value, self::cases());
    }

    /**
     * @return array<int, string>|null
     */
    public static function getSubTypesByActionType(ActionType $case): ?array
    {
        return match ($case) {
            self::Care => CareType::values(),
            self::Diaper => DiaperQuality::values(),
            self::Rest => RestQuality::values(),
            self::Lunch => LunchQuality::values(),
            default => null,
        };
    }
}
