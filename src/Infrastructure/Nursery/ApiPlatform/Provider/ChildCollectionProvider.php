<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Nursery\Query\FindChildrenQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;

/**
 * @extends AbstractCollectionProvider<Child, ChildResource>
 */
final class ChildCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildResourceFactory $childResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindChildrenQuery());
    }

    protected function toResource($model): object
    {
        return $this->childResourceFactory->fromModel($model);
    }
}
