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
     * @return array<ContractDate>|null
     */
    public function searchContractDatesByChildId(int $childId): ?array;

    /**
     * @return array<ContractDate>|null
     */
    public function searchChildrenByNurseryStructure(NurseryStructure $nurseryStructure): ?array;
}
