<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Family;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\Family\FindFamiliesByFiltersQuery;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResourceFactory;

/**
 * @extends AbstractCollectionProvider<Family, FamilyResource>
 */
final class FamilyCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly FamilyResourceFactory $familyResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        $filters = [];
        if (null !== $nurseryStructures = ($context['filters']['nursery_structures'] ?? null)) {
            $filters['nurseryStructures'] = $nurseryStructures;
        }

        return $this->queryBus->ask(new FindFamiliesByFiltersQuery($filters));
    }

    protected function toResource($model): object
    {
        return $this->familyResourceFactory->fromModel($model);
    }
}
