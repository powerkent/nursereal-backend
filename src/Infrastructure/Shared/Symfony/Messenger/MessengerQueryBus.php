<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Messenger;

use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Query\QueryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function ask(QueryInterface $query): mixed
    {
        return $this->handle((new Envelope($query))->with(new ValidationStamp([])));
    }
}
