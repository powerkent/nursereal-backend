<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Family;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Family\FindFamilyByUuidQuery;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResourceFactory;

/**
 * @extends AbstractProvider<Family, FamilyResource>
 */
final class FamilyProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly FamilyResourceFactory $familyResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Family
    {
        return $this->queryBus->ask(new FindFamilyByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Family $model
     *
     * @return FamilyResource
     */
    protected function toResource(object $model): object
    {
        return $this->familyResourceFactory->fromModel($model);
    }
}
