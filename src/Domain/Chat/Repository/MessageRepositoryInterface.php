<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Repository;

use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Message>
 */
interface MessageRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, Message>
     */
    public function searchByChannel(Channel $channel): array;
}
