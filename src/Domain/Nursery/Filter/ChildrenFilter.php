<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Filter;

use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Criteria\MultipleValuesJoinedEqualsFilter;

final class ChildrenFilter extends MultipleValuesJoinedEqualsFilter
{
    /**
     * @param list<int> $childrenIds
     */
    public function __construct(array $childrenIds)
    {
        parent::__construct('child', $childrenIds, 'type', Action::class, 'id');
    }
}
