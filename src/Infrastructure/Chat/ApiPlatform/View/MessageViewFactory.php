<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use Nursery\Domain\Chat\Model\Message;

final readonly class MessageViewFactory
{
    public function __construct(
        private MemberViewFactory $authorViewFactory,
        private ChannelViewFactory $channelViewFactory,
    ) {
    }

    public function fromModel(Message $message): MessageView
    {
        return new MessageView(
            content: $message->getContent(),
            author: $this->authorViewFactory->fromModel($message->getAuthor()),
            channel: $this->channelViewFactory->fromModel($message->getChannel()),
            createdAt: $message->getCreatedAt(),
        );
    }
}
