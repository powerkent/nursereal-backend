<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Family;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class FamilyView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public ?DateTimeInterface $updatedAt,
    ) {
    }
}
