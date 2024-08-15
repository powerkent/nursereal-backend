<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Enum;

interface SubTypeActionInterface
{
    /**
     * @return list<string>|null
     */
    public static function getSubTypesByActionType(ActionType $case): ?array;
}
