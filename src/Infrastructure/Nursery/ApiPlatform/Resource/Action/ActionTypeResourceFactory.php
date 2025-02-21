<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use Nursery\Application\Nursery\Query\Activity\FindActivitiesQuery;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;

final readonly class ActionTypeResourceFactory
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    public function fromModel(ActionType $actionType): ActionTypeResource
    {
        /** @var array<int, string>|null $subtypes */
        $subtypes = ActionType::getSubTypesByActionType($actionType);
        $actionTypes = [];
        $actionTypes[$actionType->value] = $subtypes;

        if (ActionType::Activity === $actionType) {
            $activities = $this->queryBus->ask(new FindActivitiesQuery());
            $actionTypes[$actionType->value] = [];
            foreach ($activities as $activity) {
                /* @var Activity $activity */
                $actionTypes[$actionType->value][] = $activity->getName();
            }
        }

        return new ActionTypeResource(
            actionTypes: $actionTypes,
        );
    }
}
