<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ActivityPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public UuidInterface $uuid,
        #[Groups(['action:item'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['action:put:write'])]
        public ?DateTimeInterface $endDateTime,
    ) {
    }
}
