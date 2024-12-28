<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentView;
use Symfony\Component\Serializer\Annotation\Groups;

class PresenceView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public bool $isAbsent,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?AgentView $completedAgent,
    ) {
    }
}
