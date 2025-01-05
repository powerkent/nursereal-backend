<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

final class TreatmentPayload
{
    /**
     * @param array<int, DosagePayload> $dosages
     */
    public function __construct(
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        public string $name,
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        public string $description,
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public string $startAt,
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public ?string $endAt = null,
        #[Groups(['child:item', 'treatment:item', 'treatment:list'])]
        /** @var array<int, DosagePayload> $dosages */
        public array $dosages = [],
    ) {
    }
}
