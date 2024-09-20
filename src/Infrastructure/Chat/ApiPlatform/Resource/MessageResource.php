<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use DateTimeInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Input\MessageInput;
use Nursery\Infrastructure\Chat\ApiPlatform\Processor\MessageProcessor;
use Nursery\Infrastructure\Chat\ApiPlatform\Provider\MessageCollectionProvider;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MemberView;
use Nursery\Infrastructure\Chat\ApiPlatform\View\ChannelView;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Message',
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['channel:list']],
            provider: MessageCollectionProvider::class
        ),
        new Post(
            normalizationContext: ['groups' => ['message:item', 'message:post:read']],
            denormalizationContext: ['groups' => ['message:item', 'message:post:write']],
            input: MessageInput::class,
            mercure: true,
            processor: MessageProcessor::class,
        ),
    ]
)]
final class MessageResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['message:item', 'channel:list'])]
        public ?int $id,
        #[Groups(['message:item', 'channel:list'])]
        public ?string $content,
        #[Groups(['message:item', 'channel:list'])]
        public MemberView $author,
        #[Groups(['message:item', 'channel:list'])]
        public ChannelView $channel,
        #[Groups(['message:item', 'channel:list'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
