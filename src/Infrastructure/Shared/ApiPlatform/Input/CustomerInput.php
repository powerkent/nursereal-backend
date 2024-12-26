<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class CustomerInput
{
    /**
     * @param array<array<string, string>> $children
     */
    public function __construct(
        #[Groups(['customer:item'])]
        public ?string $avatar,
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
        #[ApiProperty(openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'properties' => [
                    'uuid' => ['type' => 'string'],
                ],
            ],
            'example' => [['uuid' => 'ecef809d-6731-4b21-906f-524288122c89'], ['uuid' => '34f17460-f0ba-4e5c-a165-4d9807326596']],
        ])]
        public array $children,
    ) {
    }
}
