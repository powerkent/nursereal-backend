<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Application\Shared\Query\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindChildrenByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindConfigByUuidOrNameQuery;
use Nursery\Application\Shared\Query\FindOpeningsByNurseryStructureQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureOpeningView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureOpeningViewFactory;
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
