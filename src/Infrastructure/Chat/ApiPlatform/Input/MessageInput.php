<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Input;

use Nursery\Infrastructure\Chat\ApiPlatform\Payload\MemberPayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class MessageInput
{
    public function __construct(
        #[Groups(['message:item'])]
        public int $channelId,
        #[Groups(['message:item'])]
        public string $content,
        #[Groups(['message:item'])]
        public MemberPayload $author,
    ) {
    }
}
