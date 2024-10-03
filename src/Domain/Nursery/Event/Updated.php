<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Event;

use Nursery\Domain\Shared\Event\AbstractEvent;

final class Updated extends AbstractEvent
{
    public static function eventName(): string
    {
        return 'nursery.action.updated';
    }
}
