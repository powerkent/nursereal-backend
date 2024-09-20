<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Chat\Enum\MemberType;
use Symfony\Component\Serializer\Annotation\Groups;

final class MemberPayload
{
    public function __construct(
        #[Groups(['channel:item', 'message:item'])]
        #[ApiProperty(openapiContext: [
            'type' => 'string',
            'enum' => [MemberType::Agent->value, MemberType::Customer->value],
            'example' => MemberType::Agent->value,
        ])]
        public string $memberType,
        #[Groups(['channel:item', 'message:item'])]
        public int $memberId,
    ) {
    }
}
