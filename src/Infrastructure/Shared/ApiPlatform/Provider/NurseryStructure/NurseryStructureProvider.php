<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\NurseryStructure;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\NurseryStructure\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure\NurseryStructureResourceFactory;

/**
 * @extends AbstractProvider<NurseryStructure, NurseryStructureResource>
 */
final class NurseryStructureProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?NurseryStructure
    {
        return $this->queryBus->ask(new FindNurseryStructureByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param NurseryStructure $model
     */
    protected function toResource(object $model): object
    {
        return $this->nurseryStructureResourceFactory->fromModel($model);
    }
}
