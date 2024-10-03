<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Symfony\Component\Serializer\Annotation\Groups;

class DiaperPayload
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public DiaperQuality $diaperQuality,
    ) {
    }
}
