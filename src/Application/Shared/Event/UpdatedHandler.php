<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Event;

use Nursery\Application\Shared\Command\ClockingIn\UpdateClockingInStateCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Enum\ClockingInTransition;
use Nursery\Domain\Shared\Event\EventHandlerInterface;
use Nursery\Domain\Shared\Event\Updated;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdatedHandler implements EventHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ClockingInRepositoryInterface $clockingInRepository,
    ) {
    }

    public function __invoke(Updated $event): void
    {
        $clockingIn = $this->clockingInRepository->searchByUuid($event->uuid instanceof UuidInterface ? $event->uuid : Uuid::fromString($event->uuid));

        if (null === $clockingIn) {
            throw new EntityNotFoundException(ClockingIn::class, $event->uuid, 'uuid');
        }

        $this->commandBus->dispatch(new UpdateClockingInStateCommand($clockingIn, ClockingInTransition::Completed));
    }
}
