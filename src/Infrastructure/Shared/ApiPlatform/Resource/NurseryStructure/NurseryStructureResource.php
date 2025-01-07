<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructure\NurseryStructureDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructure\NurseryStructureProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\NurseryStructure\NurseryStructureCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\NurseryStructure\NurseryStructureProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Child\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureOpeningView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'NurseryStructure',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['nurseryStructure:item']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: NurseryStructureProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['nurseryStructure:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: NurseryStructureCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:post:read']],
            denormalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: NurseryStructureInput::class,
            processor: NurseryStructureProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:put:read']],
            denormalizationContext: ['groups' => ['nurseryStructure:item', 'nurseryStructure:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: NurseryStructureInput::class,
            provider: NurseryStructureProvider::class,
            processor: NurseryStructureProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: NurseryStructureProvider::class,
            processor: NurseryStructureDeleteProcessor::class,
        ),
    ]
)]
final class NurseryStructureResource
{
    /**
     * @param array<int, NurseryStructureOpeningView> $openings
     * @param array<int, AgentView>                   $agents
     * @param array<int, ChildView>                   $children
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public UuidInterface $uuid,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        #[ApiProperty(identifier: false)]
        public ?int $id,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $name,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public string $address,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?string $user,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?DateTimeInterface $createdAt = null,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?DateTimeInterface $updatedAt = null,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?float $latitude = null,
        #[Groups(['nurseryStructure:item', 'nurseryStructure:list'])]
        public ?float $longitude = null,
        #[Groups(['nurseryStructure:item'])]
        /** @var array<int, NurseryStructureOpeningView> $openings */
        public array $openings = [],
        #[Groups(['nurseryStructure:item'])]
        /** @var array<int, AgentView> $agents */
        public array $agents = [],
        #[Groups(['nurseryStructure:item'])]
        /** @var array<int, ChildView> */
        public array $children = [],
    ) {
    }
}
