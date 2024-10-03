<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class RestView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?RestQuality $quality,
    ) {
    }
}
