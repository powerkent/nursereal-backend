<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure;

use Nursery\Application\Shared\Query\Agent\FindAgentsByNurseryStructureQuery;
use Nursery\Application\Shared\Query\Child\FindChildrenByNurseryStructureQuery;
use Nursery\Application\Shared\Query\NurseryStructure\FindOpeningsByNurseryStructureQuery;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Address\AddressViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureOpeningView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureOpeningViewFactory;
use function array_map;

final readonly class NurseryStructureResourceFactory
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildViewFactory $childViewFactory,
        private AgentViewFactory $agentViewFactory,
        private NurseryStructureOpeningViewFactory $nurseryStructureOpeningViewFactory,
        private AddressViewFactory $addressViewFactory,
    ) {
    }

    public function fromModel(NurseryStructure $nurseryStructure): NurseryStructureResource
    {
        $children = $this->queryBus->ask(new FindChildrenByNurseryStructureQuery($nurseryStructure));
        $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
        $openings = $this->queryBus->ask(new FindOpeningsByNurseryStructureQuery($nurseryStructure));

        return new NurseryStructureResource(
            uuid: $nurseryStructure->getUuid(),
            id: $nurseryStructure->getId(),
            name: $nurseryStructure->getName(),
            address: $this->addressViewFactory->fromModel($nurseryStructure->getAddress()),
            user: isset($agents[0]) ? $agents[0]->getUser() : null,
            createdAt: $nurseryStructure->getCreatedAt(),
            updatedAt: $nurseryStructure->getUpdatedAt(),
            openings: array_map(fn (NurseryStructureOpening $opening): NurseryStructureOpeningView => $this->nurseryStructureOpeningViewFactory->fromModel($opening), $openings),
            agents: array_map(fn (Agent $agent): AgentView => $this->agentViewFactory->fromModel($agent), $agents),
            children: array_map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child), $children),
        );
    }
}
