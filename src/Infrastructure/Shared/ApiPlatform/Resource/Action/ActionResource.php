<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\ActionType;
use Nursery\Domain\Shared\Enum\CareType;
use Nursery\Domain\Shared\Enum\DiaperQuality;
use Nursery\Domain\Shared\Enum\RestQuality;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ActionPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActionCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\ActionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\ActivityView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Action\ChildView;
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
            input: ActionInput::class,
            processor: ActionPostProcessor::class,
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
    ) {
    }
}
