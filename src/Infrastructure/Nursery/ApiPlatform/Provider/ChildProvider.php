<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ChildResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;

final class ChildProvider extends AbstractProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildResourceFactory $childResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Child
    {
        return $this->queryBus->ask(new FindChildByUuidQuery(uuid: $uriVariables['uuid']));
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
