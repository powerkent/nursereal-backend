<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Nursery\Application\Shared\Query\FindChildByUuidQuery;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResourceFactory;

final class ChildProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ChildResourceFactory $childResourceFactory,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ChildResource
    {
        $child = $this->queryBus->ask(new FindChildByUuidQuery(uuid: $uriVariables['uuid']));

        return $this->childResourceFactory->fromModel($child);
    }
}
