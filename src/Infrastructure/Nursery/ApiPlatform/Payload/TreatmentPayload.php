<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentPayload
{
    public function __construct(
        #[Groups(['action:item'])]
        public UuidInterface $uuid,
        #[Groups(['action:item'])]
        public ?string $dose = null,
        #[Groups(['action:item'])]
        #[ApiProperty(openapiContext: ['example' => '08:30'])]
        public ?DateTimeInterface $dosingTime = null,
        #[Groups(['action:item'])]
        public ?float $temperature = null,
    ) {
    }
}
