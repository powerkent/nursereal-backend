<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\Doctrine\Repository;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Chat\Repository\MessageRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Message>
 */
class MessageRepository extends AbstractRepository implements MessageRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Message::class;
    }

    public function searchByChannel(Channel $channel): array
    {
        return $this->findBy(['channel' => $channel]);
    }
}
