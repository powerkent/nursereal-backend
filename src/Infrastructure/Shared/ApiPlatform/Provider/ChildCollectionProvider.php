<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindChildrenByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindChildrenQuery;
use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResourceFactory;

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
        if (null !== $nurseryStructureUuid = ($context['filters']['nursery_structure_uuid'] ?? null)) {
            $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery($nurseryStructureUuid));

            return $this->queryBus->ask(new FindChildrenByNurseryStructureQuery($nurseryStructure));
        }

        return $this->queryBus->ask(new FindChildrenQuery());
    }

    protected function toResource($model): object
    {
        return $this->childResourceFactory->fromModel($model);
    }
}
