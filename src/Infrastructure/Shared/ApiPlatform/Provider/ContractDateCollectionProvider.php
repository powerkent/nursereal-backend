<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use DateTimeImmutable;
use Nursery\Application\Shared\Query\FindChildrenByCriteriaQuery;
use Nursery\Application\Shared\Query\FindContractDatesByDateQuery;
use Nursery\Domain\Shared\Criteria\Criteria;
use Nursery\Domain\Shared\Filter\ChildFilter;
use Nursery\Domain\Shared\Filter\NurseryStructureFilter;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResourceFactory;
use function dump;

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

        $children = $this->queryBus->ask(new FindChildrenByCriteriaQuery(new Criteria($filters)));
        dump($children);

        if (null !== ($context['filters']['isToday'] ?? null)) {
            $children = array_filter($children, fn (Child $child): bool => !empty($this->queryBus->ask(new FindContractDatesByDateQuery(new DateTimeImmutable(), $child))));
        }

        dump($children);

        return $children;
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
