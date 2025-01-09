<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\ShiftType;

/**
 * @extends RepositoryInterface<ShiftType>
 */
interface ShiftTypeRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, ShiftType>|null
     */
    public function searchShiftTypesByNurseryStructure(NurseryStructure $nurseryStructure): ?array;
}
