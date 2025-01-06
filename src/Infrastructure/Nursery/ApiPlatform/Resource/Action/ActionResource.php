<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ActionDeleteProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ActionPostProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ActionPutProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ActionCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ActionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Activity\ActivityView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Care\CareView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Child\ChildView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Diaper\DiaperView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Lunch\LunchView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Milk\MilkView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Presence\PresenceView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Rest\RestView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\Treatment\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Action',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['action:item']],
            provider: ActionProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['action:list']],
            provider: ActionCollectionProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['action:item', 'action:post:read']],
            denormalizationContext: ['groups' => ['action:item', 'action:post:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: ActionInput::class,
            processor: ActionPostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['action:item', 'action:put:read']],
            denormalizationContext: ['groups' => ['action:item', 'action:put:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: ActionInput::class,
            provider: ActionProvider::class,
            processor: ActionPutProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: ActionProvider::class,
            processor: ActionDeleteProcessor::class,
        ),
    ]
)]
final class ActionResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['action:item', 'action:list'])]
        public UuidInterface $uuid,
        #[Groups(['action:item', 'action:list'])]
        public ActionType $actionType,
        #[Groups(['action:item', 'action:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $updatedAt,
        #[Groups(['action:item', 'action:list'])]
        public ChildView $child,
        #[Groups(['action:item', 'action:list'])]
        public ?string $comment = null,
        #[Groups(['action:item', 'action:list'])]
        public ?ActivityView $activity = null,
        #[Groups(['action:item', 'action:list'])]
        public ?CareView $care = null,
        #[Groups(['action:item', 'action:list'])]
        public ?DiaperView $diaper = null,
        #[Groups(['action:item', 'action:list'])]
        public ?LunchView $lunch = null,
        #[Groups(['action:item', 'action:list'])]
        public ?MilkView $milk = null,
        #[Groups(['action:item', 'action:list'])]
        public ?PresenceView $presence = null,
        #[Groups(['action:item', 'action:list'])]
        public ?RestView $rest = null,
        #[Groups(['action:item', 'action:list'])]
        public ?TreatmentView $treatment = null,
        #[Groups(['action:item', 'action:list'])]
        public ?AgentView $agent = null,
    ) {
    }
}
