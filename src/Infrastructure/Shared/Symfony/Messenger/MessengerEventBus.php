<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Messenger;

use Nursery\Domain\Shared\Event\EventBusInterface;
use Nursery\Domain\Shared\Event\EventInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;

final readonly class MessengerEventBus implements EventBusInterface
{
    public function __construct(
        private MessageBusInterface $eventBus
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function publish(EventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch(new Envelope($event)->with(new ValidationStamp([])));
        }
    }
}
