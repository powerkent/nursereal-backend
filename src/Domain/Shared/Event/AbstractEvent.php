<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Event;

use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractEvent implements EventInterface
{
    public string $occurredOn;

    public function __construct(
        public UuidInterface|string $uuid,
    ) {
        $this->occurredOn = new DateTimeImmutable()->format(DateTimeInterface::ATOM);
    }

    abstract public static function eventName(): string;
}
