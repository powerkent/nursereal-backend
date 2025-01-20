<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentEmailPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentPatchProcessor;
use DateTimeInterface;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentEmailInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentDeleteProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentPostProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent\AgentPutProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\AgentCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Agent\AgentProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Agent\AgentScheduleView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\NurseryStructure\NurseryStructureView;
use Symfony\Component\Serializer\Annotation\Groups;
use ArrayObject;

#[ApiResource(
    shortName: 'Agent',
    operations: [
        new Get(
            normalizationContext: ['groups' => ['agent:item']],
            provider: AgentProvider::class
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['agent:list']],
            security: "is_granted('".Roles::Manager->value."') or is_granted('".Roles::Agent->value."')",
            provider: AgentCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['agent:item', 'agent:post:read']],
            denormalizationContext: ['groups' => ['agent:item', 'agent:post:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: AgentInput::class,
            processor: AgentPostProcessor::class,
        ),
        new Post(
            uriTemplate: '/agents/{uuid}/send-email',
            input: AgentEmailInput::class,
            processor: AgentEmailPostProcessor::class,
        ),
        new Put(
            normalizationContext: ['groups' => ['agent:item', 'agent:put:read']],
            denormalizationContext: ['groups' => ['agent:item', 'agent:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: AgentInput::class,
            provider: AgentProvider::class,
            processor: AgentPutProcessor::class,
        ),
        new Post(
            uriTemplate: '/agents/{uuid}/confirmation',
            inputFormats: ['multipart' => ['multipart/form-data']],
            outputFormats: ['jsonld' => ['application/ld+json']],
            openapi: new Operation(
                requestBody: new RequestBody(
                    content: new ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'avatar' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ])
                )
            ),
            normalizationContext: ['groups' => ['agent:item', 'agent:patch:read']],
            provider: AgentProvider::class,
            processor: AgentPatchProcessor::class,
        ),
        new Delete(
            security: "is_granted('".Roles::Manager->value."')",
            provider: AgentProvider::class,
            processor: AgentDeleteProcessor::class,
        ),
    ],
)]
final class AgentResource
{
    /**
     * @param array<int, string>               $roles
     * @param array<int, NurseryStructureView> $nurseryStructures
     * @param array<int, AgentScheduleView>    $schedules
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['agent:item', 'agent:list'])]
        public string $uuid,
        #[ApiProperty(identifier: false)]
        #[Groups(['agent:item', 'agent:list'])]
        public ?int $id,
        #[Groups(['agent:item', 'agent:list'])]
        public ?string $avatar,
        #[Groups(['agent:item', 'agent:list'])]
        public ?string $firstname,
        #[Groups(['agent:item', 'agent:list'])]
        public ?string $lastname,
        #[Groups(['agent:item', 'agent:list'])]
        public ?string $email,
        #[Groups(['agent:item', 'agent:list'])]
        public ?string $user,
        #[Groups(['agent:item', 'agent:list'])]
        /** @var array<int, string> $roles */
        public array $roles,
        #[Groups(['agent:item', 'agent:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['agent:item', 'agent:list'])]
        public ?DateTimeInterface $updatedAt = null,
        #[Groups(['agent:item', 'agent:list'])]
        public ?bool $hasPassword = null,
        #[Groups(['agent:item', 'agent:list'])]
        /** @var array<int, NurseryStructureView> $nurseryStructures */
        public array $nurseryStructures = [],
        #[Groups(['agent:item', 'agent:list'])]
        /** @var array<int, AgentScheduleView> $schedules */
        public array $schedules = [],
    ) {
    }
}
