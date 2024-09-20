<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class MessageView
{
    public function __construct(
        #[Groups(['message:item', 'channel:item'])]
        public ?string $content,
        #[Groups(['message:item', 'channel:item'])]
        public MemberView $author,
        #[Groups(['message:item', 'channel:item'])]
        public ChannelView $channel,
        #[Groups(['message:item', 'channel:item'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
