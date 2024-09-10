<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Application\Shared\Query\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\FindChildrenByNurseryStructureQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildViewFactory;
use function array_map;

final readonly class NurseryStructureResourceFactory
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildViewFactory $childViewFactory,
        private AgentViewFactory $agentViewFactory,
    ) {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureResource
    {
        $children = $this->queryBus->ask(new FindChildrenByNurseryStructureQuery($nurseryStructure));
        $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));

        return new NurseryStructureResource(
            uuid: $nurseryStructure->getUuid(),
            name: $nurseryStructure->getName(),
            address: $nurseryStructure->getAddress(),
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            openingHour: $nurseryStructure->getOpeningHour(),
            closingHour: $nurseryStructure->getClosingHour(),
            openingDays: $nurseryStructure->getOpeningDays(),
            agents: array_map(fn (Agent $agent): AgentView => $this->agentViewFactory->fromModel($agent), $agents),
            children: array_map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child), $children),
        );
    }
}
