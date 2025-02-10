<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class CustomerInput
{
    public function __construct(
        #[Groups(['customer:item'])]
        #[Assert\NotBlank(message: 'Customer requires a firstname.')]
        public string $firstname,
        #[Groups(['customer:item'])]
        #[Assert\NotBlank(message: 'Customer requires a lastname.')]
        public string $lastname,
        #[Groups(['customer:item'])]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'parent@example.com'])]
        public ?string $email,
        #[Groups(['customer:item'])]
        #[Assert\NotBlank(message: 'Customer requires a user.')]
        public string $user,
        #[Groups(['customer:item'])]
        #[Assert\NotBlank(message: 'Customer requires a password.')]
        public string $password,
        #[Groups(['customer:item'])]
        #[ApiProperty(openapiContext: ['example' => '0606060606'])]
        public string $phoneNumber,
        #[Groups(['customer:item'])]
        public string $familyUuid,
    ) {
    }
}
