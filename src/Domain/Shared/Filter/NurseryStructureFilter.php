<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Filter;

use Nursery\Domain\Shared\Criteria\MultipleValuesJoinedEqualsFilter;
use Nursery\Domain\Shared\Model\NurseryStructure;

final class NurseryStructureFilter extends MultipleValuesJoinedEqualsFilter
{
    /**
     * @param list<string> $nurseryStructureUuids
     */
    public function __construct(array $nurseryStructureUuids)
    {
        parent::__construct('uuid', $nurseryStructureUuids, 'nurseryStructure', NurseryStructure::class, 'id');
    }
}
