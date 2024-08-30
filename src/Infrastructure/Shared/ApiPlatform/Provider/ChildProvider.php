<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResourceFactory;

/**
 * @extends AbstractProvider<Child, ChildResource>
 */
final class ChildProvider extends AbstractProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildResourceFactory $childResourceFactory,
    ) {
    }

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
