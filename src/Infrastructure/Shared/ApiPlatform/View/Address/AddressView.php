<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Address;

use Symfony\Component\Serializer\Annotation\Groups;

class AddressView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public ?int $id,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public string $address,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public int $zipcode,
        #[Groups(['child:item', 'child:list', 'customer:item', 'customer:list', 'family:item', 'family:list', 'nurseryStructure:item', 'nurseryStructure:list'])]
        public string $city,
    ) {
    }
}
