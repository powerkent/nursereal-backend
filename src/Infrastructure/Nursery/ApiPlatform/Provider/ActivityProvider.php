<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Nursery\Query\Activity\FindActivityByUuidQuery;
use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;

/**
 * @extends AbstractProvider<Activity, ActivityResource>
 */
final class ActivityProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ActivityResourceFactory $activityResourceFactory,
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
