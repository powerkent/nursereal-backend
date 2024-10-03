<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class RestPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public ?DateTimeInterface $startDateTime = null,
        #[Groups(['action:put:write'])]
        public ?DateTimeInterface $endDateTime = null,
        #[Groups(['action:put:write'])]
        public ?RestQuality $restQuality = null,
    ) {
    }
}
