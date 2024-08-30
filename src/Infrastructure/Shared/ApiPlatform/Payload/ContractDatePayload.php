<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class ContractDatePayload
{
    public function __construct(
        #[Groups(['contract:item'])]
        #[ApiProperty(openapiContext: ['example' => '2024-09-01 08:00:00'])]
        public DateTimeInterface $contractTimeStart,
        #[Groups(['contract:item'])]
        #[ApiProperty(openapiContext: ['example' => '2024-09-01 18:00:00'])]
        public DateTimeInterface $contractTimeEnd,
    ) {
    }
}
