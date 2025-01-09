<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent;

use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentViewFactory;

final readonly class AgentScheduleResourceFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(AgentSchedule $agentSchedule): AgentScheduleResource
    {
        return new AgentScheduleResource(
            uuid: $agentSchedule->getUuid(),
            id: $agentSchedule->getId(),
            agent: $this->agentViewFactory->fromModel($agentSchedule->getAgent()),
            arrivalDateTime: $agentSchedule->getArrivalDateTime(),
            endOfWorkDateTime: $agentSchedule->getEndOfWorkDateTime(),
            breakDateTime: $agentSchedule->getBreakDateTime(),
            endOfBreakDateTime: $agentSchedule->getEndOfBreakDateTime(),
        );
    }
}
