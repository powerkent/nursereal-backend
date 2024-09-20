<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use Nursery\Domain\Chat\Model\Channel;

final class ChannelViewFactory
{
    public function fromModel(Channel $channel): ChannelView
    {
        return new ChannelView(
            id: $channel->getId(),
            name: $channel->getName(),
        );
    }
}
