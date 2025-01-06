<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Activity;

use AgentViewFactory;
use Nursery\Domain\Nursery\Model\Action\Activity;

final readonly class ActivityViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(Activity $activity): ActivityView
    {
        return new ActivityView(
            uuid: $activity->getActivity()->getUuid(),
            name: $activity->getActivity()->getName(),
            description: $activity->getActivity()->getDescription(),
            comment: $activity->getComment(),
            startDateTime: $activity->getStartDateTime(),
            endDateTime: $activity->getEndDateTime(),
            completedAgent: null !== $activity->getCompletedAgent() ? $this->agentViewFactory->fromModel($activity->getCompletedAgent()) : null,
        );
    }
}
