<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\FindActivityByUuidQuery;
use Nursery\Domain\Shared\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResourceFactory;

/**
 * @extends AbstractProvider<Activity, ActivityResource>
 */
final class ActivityProvider extends AbstractProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ActivityResourceFactory $activityResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        return $this->queryBus->ask(new FindActivityByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Activity $model
     *
     * @return ActivityResource
     */
    protected function toResource(object $model): object
    {
        return $this->activityResourceFactory->fromModel($model);
    }
}
