<?php

declare(strict_types=1);

namespace ClockingIn;

use AgentViewFactory;
use Nursery\Domain\Shared\Model\ClockingIn;

final readonly class ClockingInResourceFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(ClockingIn $clockingIn): ClockingInResource
    {
        return new ClockingInResource(
            uuid: $clockingIn->getUuid(),
            id: $clockingIn->getId(),
            startDateTime: $clockingIn->getStartDateTime(),
            endDateTime: $clockingIn->getEndDateTime(),
            agent: $this->agentViewFactory->fromModel($clockingIn->getAgent()),
        );
    }
}
