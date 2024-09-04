<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentView
{
    /**
     * @param list<DosageView>|null $dosages
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'nurseryStructure:item'])]
        public ?UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?UuidInterface $childUuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'nurseryStructure:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item', 'nurseryStructure:item'])]
        public string $description,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $startAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $endAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var list<DosageView>|null $dosages */
        public ?array $dosages,
    ) {
    }
}
