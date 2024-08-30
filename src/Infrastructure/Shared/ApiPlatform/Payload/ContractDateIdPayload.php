<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use Symfony\Component\Serializer\Annotation\Groups;

final class ContractDateIdPayload
{
    public function __construct(
        #[Groups(['childCalendarEntry:item'])]
        public int $id,
    ) {
    }
}
