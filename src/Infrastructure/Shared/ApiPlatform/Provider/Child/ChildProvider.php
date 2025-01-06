<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Child;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Child\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Child\ChildResourceFactory;

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
