<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Exception;
use Nursery\Domain\Nursery\Event\Updated;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Event\EventBusInterface;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;

final readonly class UpdateActionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActionRepositoryInterface $actionRepository,
        private EventBusInterface $eventBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateActionCommand $command): Action
    {
        $action = $this->actionRepository->update($command->action);

        $this->eventBus->publish(new Updated($action->getUuid()));

        return $action;
    }
}
