<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Event;

use Nursery\Application\Nursery\Command\UpdateActionStateCommand;
use Nursery\Domain\Nursery\Enum\ActionTransition;
use Nursery\Domain\Nursery\Event\Created;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Domain\Nursery\Model\Action\Treatment;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Event\EventHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreatedHandler implements EventHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ActionRepositoryInterface $actionRepository,
    ) {
    }

    public function __invoke(Created $event): void
    {
        $action = $this->actionRepository->searchByUuid($event->uuid instanceof UuidInterface ? $event->uuid : Uuid::fromString($event->uuid));

        if (null === $action) {
            throw new EntityNotFoundException(Action::class, $event->uuid, 'uuid');
        }

        $transition = match (true) {
            $action instanceof Treatment,
            $action instanceof Diaper,
            $action instanceof Care => ActionTransition::ActionCompleted,
            default => ActionTransition::ActionInProgress,
        };

        $this->commandBus->dispatch(new UpdateActionStateCommand($action, $transition));
    }
}
