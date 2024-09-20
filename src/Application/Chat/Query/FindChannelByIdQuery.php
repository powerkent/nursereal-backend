<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Shared\Query\QueryInterface;

final readonly class FindChannelByIdQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}
