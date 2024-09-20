<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Enum;

enum MemberType: string
{
    case Agent = 'Agent';
    case Customer = 'Customer';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (MemberType $a): string => $a->value, self::cases());
    }
}
