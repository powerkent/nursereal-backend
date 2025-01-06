<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Lunch;

use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentViewFactory;

final readonly class LunchViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }
    public function fromModel(Lunch $lunch): LunchView
    {
        return new LunchView(
            lunchQuality: $lunch->getQuality(),
            startDateTime: $lunch->getStartDateTime(),
            endDateTime: $lunch->getEndDateTime(),
            completedAgent: null !== $lunch->getCompletedAgent() ? $this->agentViewFactory->fromModel($lunch->getCompletedAgent()) : null,
        );
    }
}
