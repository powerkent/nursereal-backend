<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

interface SubTypeActionInterface
{
    /**
     * @return array<int, string>|null
     */
    public static function getSubTypesByActionType(ActionType $case): ?array;
}
