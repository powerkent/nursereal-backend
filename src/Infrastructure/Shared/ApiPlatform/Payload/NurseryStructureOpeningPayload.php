<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

final class NurseryStructureOpeningPayload
{
    public function __construct(
        #[Groups(['nurseryStructure:item'])]
        #[ApiProperty(openapiContext: ['example' => '08:30'])]
        public string $openingHour,
        #[Groups(['nurseryStructure:item'])]
        #[ApiProperty(openapiContext: ['example' => '19:30'])]
        public string $closingHour,
        #[Groups(['nurseryStructure:item'])]
        #[ApiProperty(openapiContext: ['example' => 'Monday'])]
        public string $openingDay,
    ) {
    }
}
