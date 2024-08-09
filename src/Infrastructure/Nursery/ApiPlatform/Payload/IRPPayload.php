<?php

declare(strict_types=1);

namespace ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class IRPPayload
{
    public function __construct(
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child with an IRP requires a name.')]
        public string $name,
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child with an IRP requires a description.')]
        public string $description,
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child with an IRP requires a startAt')]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public string $startAt,
        #[Groups(['child:item'])]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public ?string $endAt = null,
    ) {
    }
}
