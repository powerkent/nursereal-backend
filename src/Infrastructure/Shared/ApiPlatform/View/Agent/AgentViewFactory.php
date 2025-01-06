<?php

declare(strict_types=1);


use Nursery\Domain\Shared\Model\Agent;

final readonly class AgentViewFactory
{
    public function fromModel(Agent $agent): AgentView
    {
        return new AgentView(
            uuid: $agent->getUuid(),
            avatar: $agent->getAvatar()?->getContentUrl(),
            firstname: $agent->getFirstname(),
            lastname: $agent->getLastname(),
            email: $agent->getEmail(),
            user: $agent->getUser(),
        );
    }
}
