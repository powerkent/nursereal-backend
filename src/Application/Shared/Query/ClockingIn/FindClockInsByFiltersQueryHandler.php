<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ClockingIn;

use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindClockInsByFiltersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ClockingInRepositoryInterface $clockingInRepository)
    {
    }

    /**
     * @return array<int, ClockingIn>|null
     */
    public function __invoke(FindClockInsByFiltersQuery $query): ?array
    {
        return $this->clockingInRepository->searchByFilter(
            startDateTime: $query->filters['startDateTime'],
            endDateTime: $query->filters['endDateTime'],
            nurseryStructures: array_map(fn (string $uuid): UuidInterface => Uuid::fromString($query->filters['nurseryStructures']), $query->filters['nurseryStructures']),
            agents: $query->filters['agents'] ?? [],
        );
    }
}
