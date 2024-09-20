<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Domain\Chat\Repository\MessageRepositoryInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindMessagesByChannelIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private MessageRepositoryInterface $messageRepository
    ) {
    }

    /**
     * @return array<int, Message>
     */
    final public function __invoke(FindMessagesByChannelIdQuery $query): array
    {
        $channel = $this->channelRepository->search($query->channelId);

        if (null === $channel) {
            throw new EntityNotFoundException(Channel::class, $query->channelId, 'id');
        }

        return $this->messageRepository->searchByChannel($channel);
    }
}
