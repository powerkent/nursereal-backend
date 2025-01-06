<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query\Message;

use Nursery\Domain\Shared\Query\QueryInterface;

final readonly class FindMessagesByChannelIdQuery implements QueryInterface
{
    public function __construct(public int $channelId)
    {
    }
}
