<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public int $id,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $childUuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $description,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var DosageView|null $dosages */
        public ?array $dosages,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $startAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $endAt,
    ) {
    }
}
