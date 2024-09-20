<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use Symfony\Component\Serializer\Annotation\Groups;

class MemberView
{
    public function __construct(
        #[Groups(['message:item', 'channel:item', 'channel:list'])]
        public int $memberId,
        #[Groups(['message:item', 'channel:item', 'channel:list'])]
        public ?string $firstname,
        #[Groups(['message:item', 'channel:item', 'channel:list'])]
        public ?string $lastname,
    ) {
    }
}
