<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Repository;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Channel>
 */
interface ChannelRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function searchByMemberId(int $memberId): array;
}
