<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Criteria;

final readonly class Criteria
{
    /**
     * @param iterable<FilterInterface> $filters
     */
    public function __construct(public iterable $filters)
    {
    }
}
