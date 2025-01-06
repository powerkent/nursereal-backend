<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Rest;

use AgentViewFactory;
use Nursery\Domain\Nursery\Model\Action\Rest;

final readonly class RestViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }

    public function fromModel(Rest $rest): RestView
    {
        return new RestView(
            quality: $rest->getQuality(),
            startDateTime: $rest->getStartDateTime(),
            endDateTime: $rest->getEndDateTime(),
            completedAgent: null !== $rest->getCompletedAgent() ? $this->agentViewFactory->fromModel($rest->getCompletedAgent()) : null,
        );
    }
}
