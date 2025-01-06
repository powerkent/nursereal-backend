<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Treatment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\Treatment\FindTreatmentByChildrenQuery;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Treatment\TreatmentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Treatment\TreatmentResourceFactory;

/**
 * @extends AbstractCollectionProvider<Treatment, TreatmentResource>
 */
final class TreatmentCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly TreatmentResourceFactory $treatmentResourceFactory,
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

        if ([] !== $children = (array) ($context['filters']['children'] ?? [])) {
            $childrenIds = array_map(fn (string $name): int => (int) explode(':', $name)[0], $children);
            $filters['childrenIds'] = $childrenIds;
        }

        return $this->queryBus->ask(new FindTreatmentByChildrenQuery($filters));
    }

    protected function toResource($model): object
    {
        return $this->treatmentResourceFactory->fromModel($model);
    }
}
