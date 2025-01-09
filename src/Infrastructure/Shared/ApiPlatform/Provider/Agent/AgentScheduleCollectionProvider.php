<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Application\Shared\Query\Agent\FindAgentSchedulesByAgentQuery;
use Nursery\Application\Shared\Query\Agent\FindAgentSchedulesQuery;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResourceFactory;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @extends AbstractCollectionProvider<AgentSchedule, AgentScheduleResource>
 */
final class AgentScheduleCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly AgentScheduleResourceFactory $agentScheduleResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @throws Exception
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        if (null !== $agentUuid = ($context['filters']['agent_uuid'] ?? null)) {

            $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $agentUuid));

            if (null === $agent) {
                throw new ResourceNotFoundException();
            }

            return $this->queryBus->ask(new FindAgentSchedulesByAgentQuery($agent));
        }

        return $this->queryBus->ask(new FindAgentSchedulesQuery());
    }

    /**
     * @param AgentSchedule $model
     *
     * @return AgentScheduleResource
     */
    protected function toResource($model): object
    {
        return $this->agentScheduleResourceFactory->fromModel($model);
    }
}
