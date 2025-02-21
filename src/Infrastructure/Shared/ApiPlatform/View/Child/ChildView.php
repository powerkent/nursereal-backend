<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Child;

use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRP\IRPView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChildView
{
    /**
     * @param array<int, TreatmentView>|null $treatments
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list', 'nurseryStructure:item'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list'])]
        public DateTimeInterface $birthday,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'treatment:item', 'treatment:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public ?IRPView $irp = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var array<int, TreatmentView>|null $treatments */
        public ?array $treatments = null,
    ) {
    }
}
