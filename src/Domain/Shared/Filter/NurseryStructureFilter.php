<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Filter;

use Nursery\Domain\Shared\Criteria\EqualsFilter;

final class NurseryStructureFilter extends EqualsFilter
{
    public function __construct(int $nurseryStructureIds)
    {
        parent::__construct('nurseryStructure', $nurseryStructureIds);
    }
}
