<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Resource;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MemberView;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MemberViewFactory;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MessageView;
use Nursery\Infrastructure\Chat\ApiPlatform\View\MessageViewFactory;

final readonly class ChannelResourceFactory
{
    public function __construct(
        private MessageViewFactory $messageViewFactory,
        private MemberViewFactory $memberViewFactory,
    ) {
    }

    public function fromModel(Channel $channel): ChannelResource
    {
        return new ChannelResource(
            id: $channel->getId(),
            name: $channel->getName(),
            createdAt: $channel->getCreatedAt(),
            messages: $channel->getMessages()->map(fn (Message $message): MessageView => $this->messageViewFactory->fromModel($message))->toArray(),
            members: $channel->getMembers()->map(fn (Member $member): MemberView => $this->memberViewFactory->fromModel($member))->toArray(),
        );
    }
}
