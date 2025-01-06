<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Child;

use Nursery\Domain\Shared\Criteria\Criteria;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindChildrenByCriteriaQuery implements QueryInterface
{
    public function __construct(
        public Criteria $criteria,
    ) {
    }
}
