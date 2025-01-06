<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Rest;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Symfony\Component\Serializer\Annotation\Groups;

class RestView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public ?RestQuality $quality,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?AgentView $completedAgent,
    ) {
    }
}
