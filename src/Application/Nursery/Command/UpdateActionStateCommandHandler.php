<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Exception\ActionNotEnabledTransitionException;
use Nursery\Domain\Nursery\Exception\NotEnabledTransitionException;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Domain\Nursery\Workflow\WorkflowInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final class UpdateActionStateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkflowInterface $workflow,
        private ActionRepositoryInterface $actionRepository,
    ) {
    }

    public function __invoke(UpdateActionStateCommand $command): void
    {
        try {
            $this->workflow->apply($action = $command->action, $command->transition->value, $command->context);
        } catch (NotEnabledTransitionException $exception) {
            if (($action = $exception->subject) instanceof Action) {
                throw new ActionNotEnabledTransitionException(transitionName: $exception->transitionName, workflowName: $exception->workflowName, id: $action->getId(), previous: $exception);
            }
            throw $exception;
        }

        $this->actionRepository->update($action);
    }
}
