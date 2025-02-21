<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\ClockingIn;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\ClockingIn\FindClockingInByUuidQuery;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn\ClockingInResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn\ClockingInResourceFactory;

/**
 * @extends AbstractProvider<ClockingIn, ClockingInResource>
 */
final class ClockingInProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ClockingInResourceFactory $clockingInResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?ClockingIn
    {
        return $this->queryBus->ask(new FindClockingInByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param ClockingIn $model
     *
     * @return ClockingInResource
     */
    protected function toResource(object $model): object
    {
        return $this->clockingInResourceFactory->fromModel($model);
    }
}
