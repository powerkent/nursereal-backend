<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class ChildDatesView
{
    public function __construct(
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public ?int $id,
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public DateTimeInterface $contractTimeStart,
        #[Groups(['contract:item', 'contract:list', 'contract:post:read'])]
        public DateTimeInterface $contractTimeEnd,
    ) {
    }
}
