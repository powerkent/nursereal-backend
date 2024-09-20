<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindChannelsByMemberIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChannelRepositoryInterface $channelRepository)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    final public function __invoke(FindChannelsByMemberIdQuery $query): array
    {
        return $this->channelRepository->searchByMemberId($query->memberId);
    }
}
