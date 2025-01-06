<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command\Action;

use Exception;
use Nursery\Domain\Nursery\Event\Created;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Event\EventBusInterface;

final readonly class CreateActionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActionRepositoryInterface $actionRepository,
        private EventBusInterface $eventBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateActionCommand $command): Action
    {
        $action = $this->actionRepository->save($command->action);

        $this->eventBus->publish(new Created($action->getUuid()));

        return $action;
    }
}
