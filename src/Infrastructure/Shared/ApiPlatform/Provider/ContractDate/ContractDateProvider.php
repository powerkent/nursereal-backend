<?php

declare(strict_types=1);

namespace ContractDate;

use ApiPlatform\Metadata\Operation;
use Exception;
<<<<<<< Updated upstream:src/Infrastructure/Shared/ApiPlatform/Provider/ContractDateProvider.php
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
=======
use Nursery\Application\Shared\Query\Child\FindChildByUuidOrIdQuery;
>>>>>>> Stashed changes:src/Infrastructure/Shared/ApiPlatform/Provider/ContractDate/ContractDateProvider.php
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;

/**
 * @extends AbstractProvider<Child, ContractDateResource>
 */
final class ContractDateProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ContractDateResourceFactory $contractDateResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        return $this->queryBus->ask(new FindChildByUuidOrIdQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Child $model
     *
     * @return ContractDateResource
     */
    protected function toResource(object $model): object
    {
        return $this->contractDateResourceFactory->fromModel($model);
    }
}
