<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindShiftTypeByUuidQuery;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\ShiftTypeResourceFactory;

/**
 * @extends AbstractProvider<ShiftType, ShiftTypeResource>
 */
final class ShiftTypeProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ShiftTypeResourceFactory $shiftTypeResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?ShiftType
    {
        return $this->queryBus->ask(new FindShiftTypeByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param ShiftType $model
     *
     * @return ShiftTypeResource
     */
    protected function toResource(object $model): object
    {
        return $this->shiftTypeResourceFactory->fromModel($model);
    }
}
