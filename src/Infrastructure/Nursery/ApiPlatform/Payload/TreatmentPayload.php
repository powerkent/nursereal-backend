<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

final class TreatmentPayload
{
    public function __construct(
        #[Groups(['child:item'])]
        public string $name,
        #[Groups(['child:item'])]
        public string $description,
        #[Groups(['child:item'])]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public string $startAt,
        #[Groups(['child:item'])]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public ?string $endAt = null,
        #[Groups(['child:item'])]
        /** @var list<DosagePayload> $dosages */
        public ?array $dosages = [],
    ) {
    }
}
