<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ActivityPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public UuidInterface $uuid,
    ) {
    }
}
