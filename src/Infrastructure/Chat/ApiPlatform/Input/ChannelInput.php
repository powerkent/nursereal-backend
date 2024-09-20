<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Input;

use Nursery\Infrastructure\Chat\ApiPlatform\Payload\MemberPayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class ChannelInput
{
    /**
     * @param list<MemberPayload> $members
     */
    public function __construct(
        #[Groups(['channel:item'])]
        public string $name,
        #[Groups(['channel:item'])]
        /** @var list<MemberPayload> $members */
        public array $members,
    ) {
    }
}
