<?php

declare(strict_types=1);


use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\NurseryStructure;
use NurseryStructure\NurseryStructureView;
use NurseryStructure\NurseryStructureViewFactory;

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
            user: $agent->getUser(),
            roles: $agent->getRoles(),
            createdAt: $agent->getCreatedAt(),
            updatedAt: $agent->getUpdatedAt(),
            nurseryStructures: $agent->getNurseryStructures()->map(fn (NurseryStructure $nurseryStructure): NurseryStructureView => $this->nurseryStructureViewFactory->fromModel($nurseryStructure))->toArray(),
        );
    }
}
