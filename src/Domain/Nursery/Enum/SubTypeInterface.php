<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

interface SubTypeInterface
{
    /**
     * @return list<string>
     */
    public static function values(): array;
}
