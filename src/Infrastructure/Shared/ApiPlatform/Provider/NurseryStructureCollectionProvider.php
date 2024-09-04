<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindNurseryStructuresQuery;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResourceFactory;

/**
 * @extends AbstractCollectionProvider<NurseryStructure, NurseryStructureResource>
 */
final class NurseryStructureCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly NurseryStructureResourceFactory $nurseryStructureResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindNurseryStructuresQuery());
    }

    /**
     * @param NurseryStructure $model
     */
    protected function toResource($model): object
    {
        return $this->nurseryStructureResourceFactory->fromModel($model);
    }
}
