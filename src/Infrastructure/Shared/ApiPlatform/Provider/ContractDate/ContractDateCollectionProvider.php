<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\ContractDate;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Application\Shared\Query\Child\FindChildrenByCriteriaQuery;
use Nursery\Application\Shared\Query\ContractDate\FindContractDatesByDateQuery;
use Nursery\Domain\Shared\Criteria\Criteria;
use Nursery\Domain\Shared\Filter\ChildFilter;
use Nursery\Domain\Shared\Filter\NurseryStructureFilter;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDate\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDate\ContractDateResourceFactory;

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
     * <<<<<<< Updated upstream:src/Infrastructure/Shared/ApiPlatform/Provider/ContractDateCollectionProvider.php.
     * @param  array<string, mixed>         $uriVariables
     *                                                    =======
     * @param  array<string, mixed>         $uriVariables
     *                                                    >>>>>>> Stashed changes:src/Infrastructure/Shared/ApiPlatform/Provider/ContractDate/ContractDateCollectionProvider.php
     * @throws DateMalformedStringException
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        if (null !== $nurseryStructureUuid = ($context['filters']['nursery_structure_uuid'] ?? null)) {
            $filters[] = new NurseryStructureFilter([$nurseryStructureUuid]);
        }

        if (null !== $childUuid = ($context['filters']['child_uuid'] ?? null)) {
            $filters[] = new ChildFilter($childUuid);
        }

        $children = $this->queryBus->ask(new FindChildrenByCriteriaQuery(new Criteria($filters)));

        if (null !== ($context['filters']['is_today'] ?? null)) {
            $children = array_filter($children, fn (Child $child): bool => !empty($this->queryBus->ask(new FindContractDatesByDateQuery(new DateTimeImmutable(), $child))));
        }

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
