<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Enum;

interface SubTypeActionInterface
{
    /**
     * @return list<string>|null
     */
    public static function getSubTypesByActionType(ActionType $case): ?array;
}
