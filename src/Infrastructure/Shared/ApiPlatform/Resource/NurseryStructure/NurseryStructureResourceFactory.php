<?php

declare(strict_types=1);

namespace NurseryStructure;

use AgentView;
use AgentViewFactory;
use Child\ChildView;
use Child\ChildViewFactory;
use Nursery\Application\Shared\Query\Agent\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\Child\FindChildrenByNurseryStructureQuery;
use Nursery\Application\Shared\Query\Config\FindConfigByUuidOrNameQuery;
use Nursery\Application\Shared\Query\NurseryStructure\FindOpeningsByNurseryStructureQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use function array_map;

final readonly class NurseryStructureResourceFactory
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildViewFactory $childViewFactory,
        private AgentViewFactory $agentViewFactory,
        private NurseryStructureOpeningViewFactory $nurseryStructureOpeningViewFactory,
    ) {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureResource
    {
        $children = $this->queryBus->ask(new FindChildrenByNurseryStructureQuery($nurseryStructure));
        $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
        $openings = $this->queryBus->ask(new FindOpeningsByNurseryStructureQuery($nurseryStructure));
        $agentLoginWithPhone = $this->queryBus->ask(new FindConfigByUuidOrNameQuery(name: Config::AGENT_LOGIN_WITH_PHONE));

        return new NurseryStructureResource(
            uuid: $nurseryStructure->getUuid(),
            id: $nurseryStructure->getId(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            user: !$agentLoginWithPhone || !$agentLoginWithPhone->getValue() && isset($agents[0]) ? $agents[0]->getUser() : null,
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            openings: array_map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening), $openings),
            agents: array_map(fn (Agent $agent): AgentView => $this->agentViewFactory->fromModel($agent), $agents),
            children: array_map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child), $children),
        );
    }
}
