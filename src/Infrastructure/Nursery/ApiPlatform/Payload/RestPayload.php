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
        public ?DateTimeInterface $endTime = null,
        #[Groups(['action:item'])]
        public ?RestQuality $restQuality = null,
    ) {
    }
}
