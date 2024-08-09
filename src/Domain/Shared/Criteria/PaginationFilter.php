<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Criteria;

readonly class PaginationFilter implements FilterInterface
{
    public function __construct(
        public int $page,
        public int $itemsPerPage,
    ) {
    }
}
