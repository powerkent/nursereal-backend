<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Model\Agent;

final readonly class AgentViewFactory
{
    public function fromModel(Agent $agent): AgentView
    {
        return new AgentView(
            uuid: $agent->getUuid(),
            firstname: $agent->getFirstname(),
            lastname: $agent->getLastname(),
            email: $agent->getEmail(),
        );
    }
}
