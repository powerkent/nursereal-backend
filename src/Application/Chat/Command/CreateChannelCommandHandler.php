<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Command;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateChannelCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
    ) {
    }

    public function __invoke(CreateChannelCommand $command): Channel
    {
        $channel = new Channel(...$command->primitives);

        return $this->channelRepository->save($channel);
    }
}
