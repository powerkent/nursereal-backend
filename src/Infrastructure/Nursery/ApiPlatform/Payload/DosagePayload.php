<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

final class DosagePayload
{
    public function __construct(
        #[Groups(['child:item'])]
        public ?string $dose, // quantity
        #[Groups(['child:item'])]
        #[ApiProperty(openapiContext: ['example' => '08:30'])]
        public ?string $dosingDate,
    ) {
    }
}
