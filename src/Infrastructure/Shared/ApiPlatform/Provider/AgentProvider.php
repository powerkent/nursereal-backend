<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResourceFactory;

/**
 * @extends AbstractProvider<Agent, AgentResource>
 */
final class AgentProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly AgentResourceFactory $agentResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Agent
    {
        return $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Agent $model
     *
     * @return AgentResource
     */
    protected function toResource(object $model): object
    {
        return $this->agentResourceFactory->fromModel($model);
    }
}
