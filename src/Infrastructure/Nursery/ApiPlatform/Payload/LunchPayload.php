<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\LunchQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class LunchPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['action:put:write'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:put:write'])]
        public ?LunchQuality $lunchQuality,
    ) {
    }
}
