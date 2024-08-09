<?php

declare(strict_types=1);

namespace ApiPlatform\Payload;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class DosagePayload
{
    public function __construct(
        #[Groups(['child:item'])]
        public ?string $dose, // quantity
        #[Groups(['child:item'])]
        public ?DateTimeInterface $dosingDate,
    ) {
    }
}
