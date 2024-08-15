<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action;

use Nursery\Application\Shared\Query\FindActivitiesQuery;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Enum\SubTypeInterface;
use Nursery\Domain\Shared\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;

final class ActionTypeResourceFactory
{
    public function __construct(private QueryBusInterface $queryBus)
    {
    }

    public function fromModel(ActionType $actionType): ActionTypeResource
    {
        /** @var ?SubTypeInterface $subtypes */
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
