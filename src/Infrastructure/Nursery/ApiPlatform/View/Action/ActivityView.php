<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\AgentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ActivityView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public UuidInterface $uuid,
        #[Groups(['action:item', 'action:list'])]
        public string $name,
        #[Groups(['action:item', 'action:list'])]
        public ?string $description,
        #[Groups(['action:item', 'action:list'])]
        public ?string $comment,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?AgentView $completedAgent,
    ) {
    }
}
