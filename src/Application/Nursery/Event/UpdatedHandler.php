<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Event;

use Nursery\Application\Nursery\Command\Action\UpdateActionStateCommand;
use Nursery\Domain\Nursery\Enum\ActionTransition;
use Nursery\Domain\Nursery\Event\Updated;
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

final readonly class UpdatedHandler implements EventHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ActionRepositoryInterface $actionRepository,
    ) {
    }

    public function __invoke(Updated $event): void
    {
        $action = $this->actionRepository->searchByUuid($event->uuid instanceof UuidInterface ? $event->uuid : Uuid::fromString($event->uuid));

        if (null === $action) {
            throw new EntityNotFoundException(Action::class, $event->uuid, 'uuid');
        }

        if ($action instanceof Treatment
            || $action instanceof Diaper
            || $action instanceof Care
        ) {
            return;
        }

        $this->commandBus->dispatch(new UpdateActionStateCommand($action, ActionTransition::ActionCompleted));
    }
}
