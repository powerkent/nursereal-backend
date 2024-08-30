<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

final class DosagePayload
{
    public function __construct(
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        public ?string $dose, // quantity
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        #[ApiProperty(openapiContext: ['example' => '08:30'])]
        public ?string $dosingTime,
    ) {
    }
}
