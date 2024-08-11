<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindActivityQuery;
use Nursery\Domain\Shared\Model\Activity;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResourceFactory;

/**
 * @extends AbstractCollectionProvider<Activity, ActivityResource>
 */
class ActivityCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ActivityResourceFactory $activityResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     *
     * @return Activity[]
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindActivityQuery());
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
