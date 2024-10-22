<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureViewFactory;

final readonly class AgentResourceFactory
{
    public function __construct(private NurseryStructureViewFactory $nurseryStructureViewFactory)
    {
    }

    public function fromModel(Agent $agent): AgentResource
    {
        return new AgentResource(
            uuid: $agent->getUuid(),
            id: $agent->getId(),
            avatar: $agent->getAvatar()?->getContentUrl(),
            firstname: $agent->getFirstname(),
            lastname: $agent->getLastname(),
            email: $agent->getEmail(),
            roles: $agent->getRoles(),
            createdAt: $agent->getCreatedAt(),
            updatedAt: $agent->getUpdatedAt(),
            nurseryStructures: array_map(fn (NurseryStructure $nurseryStructure): NurseryStructureView => $this->nurseryStructureViewFactory->fromModel($nurseryStructure), $agent->getNurseryStructures()->toArray()),
        );
    }
}
