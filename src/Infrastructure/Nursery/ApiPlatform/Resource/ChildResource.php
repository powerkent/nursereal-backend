<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ChildPostProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Processor\ChildPutProcessor;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ChildCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Provider\ChildProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\IRPView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\TreatmentView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Child',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['child:item']],
            provider: ChildProvider::class,
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['child:list']],
            provider: ChildCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['child:item', 'child:post:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:post:write']],
            input: ChildInput::class,
            processor: ChildPostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['child:item', 'child:put:read']],
            denormalizationContext: ['groups' => ['child:item', 'child:put:write']],
            input: ChildInput::class,
            provider: ChildProvider::class,
            processor: ChildPutProcessor::class,
        ),
    ]
)]
final class ChildResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $birthday,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?IRPView $irp = null,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        /** @var TreatmentView|null $treatments */
        public ?array $treatments = null,
        //        #[Groups(['child:item', 'child:list', 'customer:item'])]
        //        /** @var list<ActivityView>|null $activities */
        //        public ?array $activities = null,
    ) {
    }
}
