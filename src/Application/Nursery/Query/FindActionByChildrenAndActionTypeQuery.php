<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Shared\Query\QueryInterface;

final class FindActionByChildrenAndActionTypeQuery implements QueryInterface
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(public array $filters)
    {
    }
}
