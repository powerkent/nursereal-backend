<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class NurseryStructurePayload
{
    public function __construct(
        #[Groups(['agent:item', 'shiftType:item'])]
        public UuidInterface $uuid,
    ) {
    }
}
