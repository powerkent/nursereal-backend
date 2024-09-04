<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Nursery\Infrastructure\Shared\ApiPlatform\Payload\NurseryStructurePayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class AgentInput
{
    public function __construct(
        #[Groups(['agent:item'])]
        public string $firstname,
        #[Groups(['agent:item'])]
        public string $lastname,
        #[Groups(['agent:item'])]
        public string $email,
        #[Groups(['agent:item'])]
        public string $password,
        #[Groups(['agent:item'])]
        public ?NurseryStructurePayload $nurseryStructurePayload,
    ) {
    }
}
