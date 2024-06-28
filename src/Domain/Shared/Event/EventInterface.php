<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Event;

interface EventInterface
{
    public static function eventName(): string;
}
