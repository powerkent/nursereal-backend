<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum Avatar: string
{
    case Agent = 'Agent';
    case Child = 'Child';
    case Customer = 'Customer';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (Avatar $a): string => $a->value, self::cases());
    }
}
