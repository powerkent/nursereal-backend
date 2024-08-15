<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Action;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChildView
{
    public function __construct(
        #[Groups(['action:item'])]
        public UuidInterface $uuid,
        #[Groups(['action:item'])]
        public string $firstname,
        #[Groups(['action:item'])]
        public string $lastname,
    ) {
    }
}
