<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentScheduleInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentScheduleDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentSchedulePostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentSchedulePutProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\AgentScheduleCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\AgentScheduleProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'AgentSchedule',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['agentSchedule:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: AgentScheduleProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['agentSchedule:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: AgentScheduleCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['agentSchedule:item', 'agentSchedule:post:read']],
            denormalizationContext: ['groups' => ['agentSchedule:item', 'agentSchedule:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: AgentScheduleInput::class,
            provider: AgentScheduleCollectionProvider::class,
            processor: AgentSchedulePostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['agentSchedule:item', 'agentSchedule:put:read']],
            denormalizationContext: ['groups' => ['agentSchedule:item', 'agentSchedule:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: AgentScheduleInput::class,
            provider: AgentScheduleProvider::class,
            processor: AgentSchedulePutProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: AgentScheduleProvider::class,
            processor: AgentScheduleDeleteProcessor::class,
        ),
    ],
)]
final class AgentScheduleResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public UuidInterface $uuid,
        #[ApiProperty(identifier: false)]
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public ?int $id,
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public AgentView $agent,
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public DateTimeInterface $arrivalDateTime,
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public DateTimeInterface $endOfWorkDateTime,
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public DateTimeInterface $breakDateTime,
        #[Groups(['agentSchedule:item', 'agentSchedule:list'])]
        public DateTimeInterface $endOfBreakDateTime,
    ) {
    }
}
