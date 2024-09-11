<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Enum\CareType;
use Nursery\Domain\Nursery\Enum\DiaperQuality;
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\TreatmentView;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ActionProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ActionCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ActionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ActivityView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\Action\ChildView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Action',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['action:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: ActionProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['action:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: ActionCollectionProvider::class,
        ),
        new Post(
            normalizationContext: ['groups' => ['action:item', 'action:post:read']],
            denormalizationContext: ['groups' => ['action:item', 'action:post:write']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            input: ActionInput::class,
            processor: ActionProcessor::class,
        ),
    ]
)]
final class ActionResource
{
    /**
     * @param list<ChildView>     $children
     * @param list<CareType>|null $careTypes
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['action:item', 'action:list'])]
        public UuidInterface $uuid,
        #[ApiProperty(identifier: false)]
        #[Groups(['action:item', 'action:list'])]
        public ?int $id,
        #[Groups(['action:item', 'action:list'])]
        public ?ActionType $actionType,
        #[Groups(['action:item', 'action:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['action:item', 'action:list'])]
        /** @var list<ChildView> $children */
        public array $children,
        #[Groups(['action:item', 'action:list'])]
        public ?string $comment = null,
        #[Groups(['action:item', 'action:list'])]
        public ?ActivityView $activity = null,
        #[Groups(['action:item', 'action:list'])]
        /** @var list<CareType>|null $careTypes */
        public ?array $careTypes = null,
        #[Groups(['action:item', 'action:list'])]
        public ?DiaperQuality $diaperQuality = null,
        #[Groups(['action:item', 'action:list'])]
        public ?DateTimeInterface $restEndDate = null,
        #[Groups(['action:item', 'action:list'])]
        public ?RestQuality $restQuality = null,
        #[Groups(['action:item', 'action:list'])]
        public ?TreatmentView $treatment = null,
        #[Groups(['action:item', 'action:list'])]
        public ?float $temperature = null,
        #[Groups(['action:item', 'action:list'])]
        public bool $presence = false,
    ) {
    }
}
