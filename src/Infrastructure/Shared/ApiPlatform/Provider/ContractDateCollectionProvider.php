<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindChildrenByCriteriaQuery;
use Nursery\Domain\Shared\Criteria\Criteria;
use Nursery\Domain\Shared\Filter\ChildFilter;
use Nursery\Domain\Shared\Filter\NurseryStructureFilter;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResourceFactory;

/**
 * @extends AbstractCollectionProvider<Child, ContractDateResource>
 */
final class ContractDateCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ContractDateResourceFactory $contractDateResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        if (null !== $nurseryStructure = ($context['filters']['nurseryStructureId'] ?? null)) {
            $filters[] = new NurseryStructureFilter((int) $nurseryStructure);
        }

        if (null !== $child = ($context['filters']['childId'] ?? null)) {
            $filters[] = new ChildFilter((int) $child);
        }

        return $this->queryBus->ask(new FindChildrenByCriteriaQuery(new Criteria($filters)));
    }

    /**
     * @param Child $model
     *
     * @return ContractDateResource
     */
    protected function toResource($model): object
    {
        return $this->contractDateResourceFactory->fromModel($model);
    }
}
