<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChildView
{
    /**
     * @param list<TreatmentView>|null $treatments
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public DateTimeInterface $birthday,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'nurseryStructure:item'])]
        public ?IRPView $irp = null,
        #[Groups(['child:item', 'child:list', 'customer:item', 'nurseryStructure:item'])]
        /** @var list<TreatmentView>|null $treatments */
        public ?array $treatments = null,
    ) {
    }
}
