<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Presence;

use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentViewFactory;

final readonly class PresenceViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(Presence $presence): PresenceView
    {
        return new PresenceView(
            isAbsent: $presence->isAbsent(),
            startDateTime: $presence->getStartDateTime(),
            endDateTime: $presence->getEndDateTime(),
            completedAgent: null !== $presence->getCompletedAgent() ? $this->agentViewFactory->fromModel($presence->getCompletedAgent()) : null,
        );
    }
}
