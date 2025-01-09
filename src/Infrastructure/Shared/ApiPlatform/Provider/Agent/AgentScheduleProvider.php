<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindAgentScheduleByUuidQuery;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResourceFactory;

/**
 * @extends AbstractProvider<AgentSchedule, AgentScheduleResource>
 */
final class AgentScheduleProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly AgentScheduleResourceFactory $agentScheduleResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?AgentSchedule
    {
        return $this->queryBus->ask(new FindAgentScheduleByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param AgentSchedule $model
     *
     * @return AgentScheduleResource
     */
    protected function toResource(object $model): object
    {
        return $this->agentScheduleResourceFactory->fromModel($model);
    }
}
