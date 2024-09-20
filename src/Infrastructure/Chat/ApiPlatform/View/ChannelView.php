<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use Symfony\Component\Serializer\Annotation\Groups;

class ChannelView
{
    public function __construct(
        #[Groups(['message:item', 'channel:item'])]
        public ?int $id,
        #[Groups(['message:item', 'channel:item'])]
        public string $name,
    ) {
    }
}
