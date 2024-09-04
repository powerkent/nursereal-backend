<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiProperty;

final class AgentLoginInput
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(example: 'agent@example.com')]
        #[Groups(['agent:login'])]
        public string $email,
        #[Assert\NotBlank]
        #[ApiProperty(example: 'password123')]
        #[Groups(['agent:login'])]
        public string $password,
    ) {
    }
}
