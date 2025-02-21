<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query\Channel;

use Nursery\Domain\Shared\Query\QueryInterface;

final readonly class FindChannelsByMemberIdQuery implements QueryInterface
{
    public function __construct(public int $memberId)
    {
    }
}
