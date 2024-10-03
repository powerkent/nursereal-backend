<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class MilkPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['action:put:write'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['action:put:write'])]
        public ?string $quantity,
    ) {
    }
}