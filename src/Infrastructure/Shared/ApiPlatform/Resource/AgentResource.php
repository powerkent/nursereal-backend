<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\AgentDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\AgentProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AgentCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AgentProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructureView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Agent',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['agent:item']],
            provider: AgentProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['agent:list']],
            provider: AgentCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['agent:item', 'agent:post:read']],
            denormalizationContext: ['groups' => ['agent:item', 'agent:post:write']],
            input: AgentInput::class,
            processor: AgentProcessor::class,
        ),
        new Delete(
            provider: AgentProvider::class,
            processor: AgentDeleteProcessor::class,
        ),
    ],
)]
final class AgentResource
{
    /**
     * @param list<string>               $roles
     * @param list<NurseryStructureView> $nurseryStructures
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['agent:item', 'agent:list'])]
        public UuidInterface $uuid,
        #[Groups(['agent:item', 'agent:list'])]
        public string $firstname,
        #[Groups(['agent:item', 'agent:list'])]
        public string $lastname,
        #[Groups(['agent:item', 'agent:list'])]
        public string $email,
        #[Groups(['agent:item', 'agent:list'])]
        /** @var list<string> $roles */
        public array $roles,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['agent:item', 'agent:list'])]
        /** @var list<NurseryStructureView> $nurseryStructures */
        public ?array $nurseryStructures = null,
        #[Groups(['agent:item', 'agent:list'])]
        public ?DateTimeInterface $updatedAt = null,
    ) {
    }
}
