<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Agent;

use Nursery\Domain\Shared\Model\AgentSchedule;

final readonly class AgentScheduleViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(AgentSchedule $agentSchedule): AgentScheduleView
    {
        return new AgentScheduleView(
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
