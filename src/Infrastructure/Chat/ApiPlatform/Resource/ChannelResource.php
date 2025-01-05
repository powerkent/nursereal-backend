<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Input\ChannelInput;
use Nursery\Infrastructure\Chat\ApiPlatform\Processor\ChannelProcessor;
use Nursery\Infrastructure\Chat\ApiPlatform\Provider\ChannelCollectionProvider;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MemberView;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MessageView;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Channel',
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['channel:list']],
            provider: ChannelCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['channel:item', 'channel:post:read']],
            denormalizationContext: ['groups' => ['channel:item', 'channel:post:write']],
            input: ChannelInput::class,
            processor: ChannelProcessor::class,
        ),
    ]
)]
final class ChannelResource
{
    /**
     * @param array<int, MessageView> $messages
     * @param array<int, MemberView>  $members
     */
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['channel:item', 'channel:list'])]
        public ?int $id,
        #[Groups(['channel:item', 'channel:list'])]
        public string $name,
        #[Groups(['channel:item', 'channel:list'])]
        public DateTimeInterface $createdAt,
        #[Groups(['channel:item'])]
        /** @var array<int, MessageView> $messages */
        public array $messages = [],
        #[Groups(['channel:item', 'channel:list'])]
        /** @var array<int, MemberView> $members */
        public array $members = [],
    ) {
    }
}
