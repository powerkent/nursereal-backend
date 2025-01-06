<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ClockingInInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ClockingInProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ClockingIn\ClockingInCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ClockingIn\ClockingInProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'ClockingIn',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['clockingIn:item']],
            //security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: ClockingInProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['clockingIn:list']],
            //security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: ClockingInCollectionProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['clockingIn:item', 'clockingIn:post:read']],
            denormalizationContext: ['groups' => ['clockingIn:item', 'clockingIn:post:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: ClockingInInput::class,
            processor: ClockingInProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['clockingIn:item', 'clockingIn:post:read']],
            denormalizationContext: ['groups' => ['clockingIn:item', 'clockingIn:post:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: ClockingInInput::class,
            provider: ClockingInProvider::class,
            processor: ClockingInProcessor::class,
        ),
    ]
)]
final class ClockingInResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['clockingIn:item', 'clockingIn:list'])]
        public UuidInterface $uuid,
        #[ApiProperty(identifier: false)]
        #[Groups(['clockingIn:item', 'clockingIn:list'])]
        public ?int $id,
        #[Groups(['clockingIn:item', 'clockingIn:list'])]
        public DateTimeInterface $startDateTime,
        #[Groups(['clockingIn:item', 'clockingIn:list'])]
        public ?DateTimeInterface $endDateTime,
        #[Groups(['clockingIn:item', 'clockingIn:list'])]
        public AgentView $agent,
    ) {
    }
}
