<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ClockingIn;

use Nursery\Domain\Nursery\Exception\ActionNotEnabledTransitionException;
use Nursery\Domain\Nursery\Exception\NotEnabledTransitionException;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Nursery\Domain\Shared\Workflow\WorkflowInterface;

final readonly class UpdateClockingInStateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private WorkflowInterface $workflow,
        private ClockingInRepositoryInterface $clockingInRepository,
    ) {
    }

    public function __invoke(UpdateClockingInStateCommand $command): void
    {
        try {
            $this->workflow->apply($clockingIn = $command->clockingIn, $command->transition->value, $command->context);
        } catch (NotEnabledTransitionException $exception) {
            if (($clockingIn = $exception->subject) instanceof ClockingIn) {
                throw new ActionNotEnabledTransitionException(transitionName: $exception->transitionName, workflowName: $exception->workflowName, id: $clockingIn->getId(), previous: $exception);
            }
            throw $exception;
        }

        $this->clockingInRepository->update($clockingIn);
    }
}
