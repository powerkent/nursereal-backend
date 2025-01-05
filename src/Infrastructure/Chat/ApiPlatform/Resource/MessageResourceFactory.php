<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Resource;

use Nursery\Domain\Chat\Model\Message;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MemberViewFactory;
use Nursery\Infrastructure\Chat\ApiPlatform\View\ChannelViewFactory;

final readonly class MessageResourceFactory
{
    public function __construct(
        private MemberViewFactory $authorViewFactory,
        private ChannelViewFactory $channelViewFactory,
    ) {
    }

    public function fromModel(Message $message): MessageResource
    {
        return new MessageResource(
            id: $message->getId(),
            content: $message->getContent(),
            author: $this->authorViewFactory->fromModel($message->getAuthor()),
            channel: $this->channelViewFactory->fromModel($message->getChannel()),
            createdAt: $message->getCreatedAt(),
        );
    }
}
