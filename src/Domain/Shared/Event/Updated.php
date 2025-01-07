<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Event;

final class Updated extends AbstractEvent
{
    public static function eventName(): string
    {
        return 'nursery.clockingIn.updated';
    }
}
