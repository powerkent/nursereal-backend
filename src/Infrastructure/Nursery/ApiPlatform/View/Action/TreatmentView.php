<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentView
{
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        public string $name,
        #[Groups(['action:item', 'action:list'])]
        public ?string $description,
        #[Groups(['action:item', 'action:list'])]
        public ?string $dose,
        #[Groups(['action:item', 'action:list'])]
        public ?string $dosingTime,
    ) {
    }
}
