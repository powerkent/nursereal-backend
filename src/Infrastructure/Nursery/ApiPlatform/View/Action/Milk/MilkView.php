<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Milk;

use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Symfony\Component\Serializer\Annotation\Groups;

class MilkView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public ?string $quantity,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?AgentView $completedAgent,
    ) {
    }
}
