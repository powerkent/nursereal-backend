<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Model\Treatment;

/**
 * @extends RepositoryInterface<Treatment>
 */
interface TreatmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param list<int> $children
     *
     * @return array<Treatment>|null
     */
    public function searchByFilter(array $children = []): ?array;
}
