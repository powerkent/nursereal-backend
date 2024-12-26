<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class AgentView
{
    public function __construct(
        #[Groups(['nurseryStructure:item'])]
        public UuidInterface $uuid,
        #[Groups(['nurseryStructure:item'])]
        public ?string $firstname,
        #[Groups(['nurseryStructure:item'])]
        public ?string $lastname,
        #[Groups(['nurseryStructure:item'])]
        public ?string $email,
        #[Groups(['nurseryStructure:item'])]
        public ?string $user,
    ) {
    }
}
