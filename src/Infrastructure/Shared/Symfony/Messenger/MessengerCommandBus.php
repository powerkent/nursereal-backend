<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Messenger;

use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Command\CommandInterface;
use Nursery\Domain\Shared\Command\RoutableCommandInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\ValidationStamp;

final class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    public function dispatch(RoutableCommandInterface $command): mixed
    {
        if ($command instanceof CommandInterface) {
            return $this->handleSync($command);
        }

        $this->handleRoutable($command);

        return null;
    }

    private function handleSync(CommandInterface $command): mixed
    {
        return $this->handle(new Envelope($command)->with(new ValidationStamp([])));
    }

    private function handleRoutable(RoutableCommandInterface $command): void
    {
        $envelope = new Envelope($command)->with(new ValidationStamp([]));

        $this->messageBus->dispatch($envelope);
    }
}
