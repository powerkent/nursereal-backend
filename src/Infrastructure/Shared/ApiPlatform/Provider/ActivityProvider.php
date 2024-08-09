<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Nursery\Domain\Shared\Query\FindActivityByUuidQuery;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActivityResourceFactory;

final readonly class ActivityProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ActivityResourceFactory $activityResourceFactory,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ActivityResource
    {
        $child = $this->queryBus->ask(new FindActivityByUuidQuery(uuid: $uriVariables['uuid']));

        return $this->activityResourceFactory->fromModel($child);
    }
}
