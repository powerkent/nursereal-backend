<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindAgentsQuery;
use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResourceFactory;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * @extends AbstractCollectionProvider<Agent, AgentResource>
 */
final class AgentCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentResourceFactory $agentResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        if (null !== $nurseryStructureUuid = ($context['filters']['nursery_structure_uuid'] ?? null)) {
            $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery($nurseryStructureUuid));

            if (null === $nurseryStructure) {
                throw new ResourceNotFoundException();
            }

            return $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
        }

        return $this->queryBus->ask(new FindAgentsQuery());
    }

    /**
     * @param Agent $model
     *
     * @return AgentResource
     */
    protected function toResource($model): object
    {
        return $this->agentResourceFactory->fromModel($model);
    }
}
