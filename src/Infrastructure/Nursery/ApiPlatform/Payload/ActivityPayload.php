<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ActivityPayload
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
    ) {
    }
}
