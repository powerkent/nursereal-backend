<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Domain\Nursery\Model\Action\Diaper;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Domain\Nursery\Model\Action\Treatment;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ActivityViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ChildView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ChildViewFactory;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\TreatmentViewFactory;
use function get_class;
use function strtolower;

final readonly class ActionResourceFactory
{
    public function __construct(
        private ChildViewFactory $childViewFactory,
        private ActivityViewFactory $activityViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
    ) {
    }

    public function fromModel(Action $action): ActionResource
    {
        $actionPath = explode('\\', get_class($action));
        $actionType = $actionPath[count($actionPath) - 1];

        return new ActionResource(
            uuid: $action->getUuid(),
            id: $action->getId(),
            actionType: ActionType::tryFrom(strtolower($actionType)),
            createdAt: $action->getCreatedAt(),
            children: $action->getChildren()->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
            comment: $action->getComment(),
            activity: $action instanceof Activity ? $this->activityViewFactory->fromModel($action) : null,
            careTypes: $action instanceof Care ? $action->getTypes() : null,
            diaperQuality: $action instanceof Diaper ? $action->getQuality() : null,
            restEndDate: $action instanceof Rest ? $action->getEndDateTime() : null,
            restQuality: $action instanceof Rest ? $action->getQuality() : null,
            treatment: $action instanceof Treatment ? $this->treatmentViewFactory->fromModel($action) : null,
            temperature: $action instanceof Treatment ? $action->getTemperature() : null,
        );
    }
}
