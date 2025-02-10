<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ChildPayload
{
    public function __construct(
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Child requires a firstname.')]
        public string $firstname,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Child requires a lastname.')]
        public string $lastname,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Child requires a birthday')]
        #[ApiProperty(openapiContext: ['example' => '2024-01-01 00:00:00'])]
        public string $birthday,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Child requires a gender.')]
        public string $gender,
        #[Groups(['family:item'])]
        public ?string $internalComment = null,
    ) {
    }
}
