<?php

declare(strict_types=1);

namespace Child;

use ApiPlatform\Metadata\Operation;
<<<<<<< Updated upstream:src/Infrastructure/Shared/ApiPlatform/Provider/ChildProvider.php
use Exception;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
=======
>>>>>>> Stashed changes:src/Infrastructure/Shared/ApiPlatform/Provider/Child/ChildProvider.php
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;

/**
 * @extends AbstractProvider<Child, ChildResource>
 */
final class ChildProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ChildResourceFactory $childResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Child
    {
        return $this->queryBus->ask(new FindChildByUuidOrIdQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Child $model
     *
     * @return ChildResource
     */
    protected function toResource(object $model): object
    {
        return $this->childResourceFactory->fromModel($model);
    }
}
