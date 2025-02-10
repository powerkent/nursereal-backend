<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\AgeGroup;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class AgeGroupView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public int $adultChildRatio,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public int $minAge,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $updatedAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?int $maxAge,
    ) {
    }
}
