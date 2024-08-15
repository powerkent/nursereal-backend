<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action;

use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Model\AbstractAction;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Model\Action\Activity;
use Nursery\Domain\Shared\Model\Action\Care;
use Nursery\Domain\Shared\Model\Action\Diaper;
use Nursery\Domain\Shared\Model\Action\Rest;
use Nursery\Domain\Shared\Model\Action\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\ActivityViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\ChildViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\TreatmentViewFactory;
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

    public function fromModel(AbstractAction $action): ActionResource
    {
        $actionPath = explode('\\', get_class($action));
        $actionType = $actionPath[count($actionPath) - 1];

        return new ActionResource(
            uuid: $action->getUuid(),
            actionType: ActionType::tryFrom(strtolower($actionType)),
            createdAt: $action->getCreatedAt(),
            children: $action->getChildren()->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
            comment: $action->getComment(),
            activity: $action instanceof Activity ? $this->activityViewFactory->fromModel($action) : null,
            careTypes: $action instanceof Care ? $action->getCareTypes() : null,
            diaperQuality: $action instanceof Diaper ? $action->getDiaperQuality() : null,
            restEndDate: $action instanceof Rest ? $action->getRestEndDate() : null,
            restQuality: $action instanceof Rest ? $action->getRestQuality() : null,
            treatment: $action instanceof Treatment ? $this->treatmentViewFactory->fromModel($action) : null,
            temperature: $action instanceof Treatment ? $action->getTemperature() : null,
        );
    }
}
