<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

enum Roles: string
{
    case Manager = 'ROLE_MANAGER';
    case Agent = 'ROLE_AGENT';
    case Parent = 'ROLE_PARENT';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (Roles $r): string => $r->value, self::cases());
    }
}
