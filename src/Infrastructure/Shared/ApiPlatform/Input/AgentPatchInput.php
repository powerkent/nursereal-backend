<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class AgentPatchInput
{
    public function __construct(
        #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/png'])]
        #[Groups(['agent:item'])]
        public ?File $avatar = null,
        #[Assert\Length(min: 8)]
        #[Groups(['agent:item'])]
        public ?string $username = null,
        #[Groups(['agent:item'])]
        public ?string $password = null,
    ) {
    }
}
