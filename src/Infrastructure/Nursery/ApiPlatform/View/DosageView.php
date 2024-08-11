<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class DosageView
{
    public function __construct(
        #[Groups(['child:item', 'child:list'])]
        public ?string $dose, // quantity
        #[Groups(['child:item', 'child:list'])]
        public ?DateTimeInterface $dosingDate,
    ) {
    }
}
