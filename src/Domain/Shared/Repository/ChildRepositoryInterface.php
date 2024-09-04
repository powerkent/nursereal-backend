<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Model\NurseryStructure;

/**
 * @extends RepositoryInterface<Child>
 */
interface ChildRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, ContractDate>|null
     */
    public function searchContractDatesByChildId(int $childId): ?array;

    /**
     * @return array<int, Child>|null
     */
    public function searchChildrenByNurseryStructure(NurseryStructure $nurseryStructure): ?array;
}
