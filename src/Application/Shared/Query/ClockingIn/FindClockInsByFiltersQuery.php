<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ClockingIn;

use Nursery\Domain\Shared\Query\QueryInterface;

final class FindClockInsByFiltersQuery implements QueryInterface
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(public array $filters)
    {
    }
}