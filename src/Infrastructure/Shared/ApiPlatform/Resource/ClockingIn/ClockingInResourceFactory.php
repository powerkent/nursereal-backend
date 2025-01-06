<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn;

use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentViewFactory;

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
