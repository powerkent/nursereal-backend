<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Agent;

final readonly class AgentResourceFactory
{
    public function fromModel(Agent $agent): AgentResource
    {
        return new AgentResource(
            uuid: $agent->getUuid(),
            firstname: $agent->getFirstname(),
            lastname: $agent->getLastname(),
            email: $agent->getEmail(),
            roles: $agent->getRoles(),
            createdAt: $agent->getCreatedAt(),
            updatedAt: $agent->getUpdatedAt(),
        );
    }
}
