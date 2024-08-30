<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChildView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public UuidInterface $uuid,
        #[Groups(['action:item', 'action:list'])]
        public ?int $id,
        #[Groups(['action:item', 'action:list'])]
        public string $firstname,
        #[Groups(['action:item', 'action:list'])]
        public string $lastname,
    ) {
    }
}
