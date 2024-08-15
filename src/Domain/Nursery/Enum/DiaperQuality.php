<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

enum DiaperQuality: string implements SubTypeInterface
{
    case Liquid = 'liquid';
    case Soft = 'soft';
    case Correct = 'correct';
    case Hard = 'hard';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (DiaperQuality $a): string => $a->value, self::cases());
    }
}
