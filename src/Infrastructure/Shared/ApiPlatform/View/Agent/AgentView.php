<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Agent;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class AgentView
{
    public function __construct(
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public UuidInterface $uuid,
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public ?string $avatar,
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public ?string $firstname,
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public ?string $lastname,
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public ?string $email,
        #[Groups(['nurseryStructure:item', 'action:item', 'action:list', 'clockingIn:item', 'clockingIn:list', 'agentSchedule:item', 'agentSchedule:list'])]
        public ?string $user,
    ) {
    }
}
