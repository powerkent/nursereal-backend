<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindShiftTypesByNurseryStructureQuery implements QueryInterface
{
    public function __construct(public NurseryStructure $nurseryStructure)
    {
    }
}
