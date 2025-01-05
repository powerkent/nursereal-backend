<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Nursery\Query\FindActivitiesQuery;
use Nursery\Domain\Shared\Criteria\FilterInterface;
use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResourceFactory;

/**
 * @extends AbstractCollectionProvider<Activity, ActivityResource>
 */
class ActivityCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ActivityResourceFactory $activityResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed>  $uriVariables
     * @param list<FilterInterface> $filters
     *
     * @return Activity[]
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindActivitiesQuery());
    }

    /**
     * @param Activity $model
     *
     * @return ActivityResource
     */
    protected function toResource($model): object
    {
        return $this->activityResourceFactory->fromModel($model);
    }
}
