<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Milk;

use AgentViewFactory;
use Nursery\Domain\Nursery\Model\Action\Milk;

final readonly class MilkViewFactory
{
    public function __construct(private AgentViewFactory $agentViewFactory)
    {
    }
    public function fromModel(Milk $milk): MilkView
    {
        return new MilkView(
            quantity: $milk->getQuantity(),
            startDateTime: $milk->getStartDateTime(),
            endDateTime: $milk->getEndDateTime(),
            completedAgent: $milk->getCompletedAgent() ? $this->agentViewFactory->fromModel($milk->getCompletedAgent()) : null,
        );
    }
}
