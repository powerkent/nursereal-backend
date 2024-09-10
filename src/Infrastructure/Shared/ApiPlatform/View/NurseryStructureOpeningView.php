<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Nursery\Domain\Shared\Enum\OpeningDays;
use Symfony\Component\Serializer\Annotation\Groups;

class NurseryStructureOpeningView
{
    public function __construct(
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $openingHour,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $closingHour,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public OpeningDays $openingDay,
    ) {
    }
}
