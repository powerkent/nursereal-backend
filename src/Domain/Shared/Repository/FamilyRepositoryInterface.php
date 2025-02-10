<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Family;

/**
 * @extends RepositoryInterface<Family>
 */
interface FamilyRepositoryInterface extends RepositoryInterface
{
    /**
     * @param  array<int, string> $nurseryStructures
     * @return array<int, Family>
     */
    public function searchByNurseryStructures(array $nurseryStructures): array;
}
