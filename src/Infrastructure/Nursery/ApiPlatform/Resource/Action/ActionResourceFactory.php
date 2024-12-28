<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Domain\Nursery\Model\Action\Milk;
use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Domain\Nursery\Model\Action\Treatment;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ActivityViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\CareViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ChildViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\DiaperViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\LunchViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\MilkViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\PresenceViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\RestViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\TreatmentViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentViewFactory;

final readonly class ActionResourceFactory
{
    public function __construct(
        private ChildViewFactory $childViewFactory,
        private ActivityViewFactory $activityViewFactory,
        private CareViewFactory $careViewFactory,
        private DiaperViewFactory $diaperViewFactory,
        private LunchViewFactory $lunchViewFactory,
        private MilkViewFactory $milkViewFactory,
        private PresenceViewFactory $presenceViewFactory,
        private RestViewFactory $restViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
        private AgentViewFactory $agentViewFactory,
    ) {
    }

    public function fromModel(Action $action): ActionResource
    {
        return new ActionResource(
            uuid: $action->getUuid(),
            actionType: $action->getType(),
            createdAt: $action->getCreatedAt(),
            updatedAt: $action->getUpdatedAt(),
            child: $this->childViewFactory->fromModel($action->getChild()),
            comment: $action->getComment(),
            activity: $action instanceof Activity ? $this->activityViewFactory->fromModel($action) : null,
            care: $action instanceof Care ? $this->careViewFactory->fromModel($action) : null,
            diaper: $action instanceof Diaper ? $this->diaperViewFactory->fromModel($action) : null,
            lunch: $action instanceof Lunch ? $this->lunchViewFactory->fromModel($action) : null,
            milk: $action instanceof Milk ? $this->milkViewFactory->fromModel($action) : null,
            presence: $action instanceof Presence ? $this->presenceViewFactory->fromModel($action) : null,
            rest: $action instanceof Rest ? $this->restViewFactory->fromModel($action) : null,
            treatment: $action instanceof Treatment ? $this->treatmentViewFactory->fromModel($action) : null,
            agent: $this->agentViewFactory->fromModel($action->getAgent()),
        );
    }
}
