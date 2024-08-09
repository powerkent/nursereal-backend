<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class IRPView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public int $id,
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
    ) {
    }
}
