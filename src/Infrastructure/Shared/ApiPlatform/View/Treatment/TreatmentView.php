<?php

declare(strict_types=1);

namespace Treatment;

use DateTimeInterface;
use Dosage\DosageView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentView
{
    /**
     * @param array<int, DosageView> $dosages
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?UuidInterface $childUuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $description,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $startAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $endAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var array<int, DosageView> $dosages */
        public array $dosages,
    ) {
    }
}
