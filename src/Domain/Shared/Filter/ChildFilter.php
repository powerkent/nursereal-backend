<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Filter;

use Nursery\Domain\Shared\Criteria\EqualsFilter;

final class ChildFilter extends EqualsFilter
{
    public function __construct(string $child)
    {
        parent::__construct('uuid', $child);
    }
}
