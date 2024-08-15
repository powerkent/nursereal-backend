<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ChildView
{
    /**
     * @param list<TreatmentView>|null $treatments
     */
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public DateTimeInterface $birthday,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list'])]
        public ?IRPView $irp = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var list<TreatmentView>|null $treatments */
        public ?array $treatments = null,
    ) {
    }
}
