<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Symfony\Component\Serializer\Annotation\Groups;

class DosageView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'treatment:item', 'treatment:list'])]
        public ?string $dose, // quantity
        #[Groups(['child:item', 'child:list', 'customer:item', 'treatment:item', 'treatment:list'])]
        public ?string $dosingTime,
    ) {
    }
}
