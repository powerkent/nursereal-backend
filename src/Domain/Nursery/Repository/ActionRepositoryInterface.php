<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Repository;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Action>
 */
interface ActionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param list<int>          $children
     * @param array<int, string> $actions
     * @param list<string>       $nurseryStructures
     * @param list<string>       $agents
     *
     * @return array<Action>|null
     */
    public function searchByFilter(
        DateTimeInterface $startDateTime,
        DateTimeInterface $endDateTime,
        ?ActionState $state = null,
        array $children = [],
        array $actions = [],
        array $nurseryStructures = [],
        array $agents = [],
    ): ?array;
}
