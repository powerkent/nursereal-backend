<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\LunchQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class LunchView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:item', 'action:list'])]
        public ?LunchQuality $lunchQuality,
    ) {
    }
}
