<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Agent;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class AgentScheduleView
{
    public function __construct(
        #[Groups(['agent:item', 'agent:list'])]
        public UuidInterface $uuid,
        #[Groups(['agent:item', 'agent:list'])]
        public ?int $id,
        #[Groups(['agent:item', 'agent:list'])]
        public AgentView $agent,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $arrivalDateTime,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $endOfWorkDateTime,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $breakDateTime,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $endOfBreakDateTime,
    ) {
    }
}
