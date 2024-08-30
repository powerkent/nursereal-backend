<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;

/**
 * @extends RepositoryInterface<Child>
 */
interface ChildRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<ContractDate>|null
     */
    public function searchByFilter(int $childId): ?array;
}
