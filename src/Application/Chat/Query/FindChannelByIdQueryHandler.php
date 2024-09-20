<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindChannelByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChannelRepositoryInterface $channelRepository)
    {
    }

    final public function __invoke(FindChannelByIdQuery $query): ?Channel
    {
        return $this->channelRepository->search($query->id);
    }
}
