<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\Doctrine\Repository;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Channel>
 */
class ChannelRepository extends AbstractRepository implements ChannelRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Channel::class;
    }

    public function searchByMemberId(int $memberId): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare(
            'SELECT cc.*
            FROM chat_channel cc
            JOIN chat_channel_member ccm on ccm.channel_id = cc.id
            JOIN chat_member cm on ccm.member_id = cm.id
            WHERE cm.member_id = :memberId'
        );

        $results = $stmt->executeQuery([
            'memberId'   => $memberId,
        ]);

        return $results->fetchAllAssociative();
    }
}
