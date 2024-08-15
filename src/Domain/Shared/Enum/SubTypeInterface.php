<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

interface SubTypeInterface
{
    /**
     * @return list<string>
     */
    public static function values(): array;
}
