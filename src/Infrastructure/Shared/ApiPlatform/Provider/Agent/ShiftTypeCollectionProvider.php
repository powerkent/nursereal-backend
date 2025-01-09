<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\Agent\FindShiftTypesQuery;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResourceFactory;

/**
 * @extends AbstractCollectionProvider<ShiftType, ShiftTypeResource>
 */
final class ShiftTypeCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ShiftTypeResourceFactory $shiftTypeResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindShiftTypesQuery());
    }

    /**
     * @param ShiftType $model
     *
     * @return ShiftTypeResource
     */
    protected function toResource($model): object
    {
        return $this->shiftTypeResourceFactory->fromModel($model);
    }
}
