<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Event;

interface EventBusInterface
{
    public function publish(EventInterface ...$events): void;
}
