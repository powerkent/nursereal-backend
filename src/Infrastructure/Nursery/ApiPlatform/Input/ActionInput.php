<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use DateTimeInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\ActivityPayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\PresencePayload;
use Nursery\Infrastructure\Nursery\ApiPlatform\Payload\TreatmentPayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class ActionInput
{
    /**
     * @param array<array<string, string>> $children
     */
    public function __construct(
        #[Groups(['action:item'])]
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
        #[Groups(['action:item'])]
        public ?string $comment = null,
        #[Groups(['action:item'])]
        public ?ActivityPayload $activity = null,
        #[Groups(['action:item'])]
        public ?DateTimeInterface $restEndTime = null,
        #[Groups(['action:item'])]
        public ?TreatmentPayload $treatment = null,
        #[Groups(['action:item'])]
        public ?PresencePayload $presence = null,
    ) {
    }
}
