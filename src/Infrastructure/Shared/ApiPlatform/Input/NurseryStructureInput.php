<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class NurseryStructureInput
{
    public function __construct(
        #[Groups(['nurseryStructure:item'])]
        public string $name,
        #[Groups(['nurseryStructure:item'])]
        public string $address,
        #[Groups(['nurseryStructure:item'])]
        public DateTimeInterface $startAt,
        #[Groups(['nurseryStructure:item'])]
        public DateTimeInterface $endAt,
    ) {
    }
}
