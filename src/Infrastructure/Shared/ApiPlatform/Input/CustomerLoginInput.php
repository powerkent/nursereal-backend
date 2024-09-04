<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiProperty;

final class CustomerLoginInput
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(example: 'parent@example.com')]
        #[Groups(['customer:login'])]
        public string $email,
        #[Assert\NotBlank]
        #[ApiProperty(example: 'password123')]
        #[Groups(['customer:login'])]
        public string $password,
    ) {
    }
}
