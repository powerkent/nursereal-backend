<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Repository;

use DateTimeInterface;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Action>
 */
interface ActionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param list<int>    $children
     * @param list<string> $actions
     * @param list<string> $nurseryStructures
     *
     * @return array<Action>|null
     */
    public function searchByFilter(
        DateTimeInterface $startDateTime,
        DateTimeInterface $endDateTime,
        array $children = [],
        array $actions = [],
        array $nurseryStructures = []
    ): ?array;
}
