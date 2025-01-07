<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use DateTimeInterface;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Model\ClockingIn;
use Ramsey\Uuid\UuidInterface;

/**
 * @extends RepositoryInterface<ClockingIn>
 */
interface ClockingInRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array<int, UuidInterface> $nurseryStructures
     * @param array<int, Agent>         $agents
     *
     * @return array<ClockingIn>|null
     */
    public function searchByFilter(
        DateTimeInterface $startDateTime,
        DateTimeInterface $endDateTime,
        array $nurseryStructures = [],
        array $agents = [],
        ?ClockingInState $state = null,
    ): ?array;
}
