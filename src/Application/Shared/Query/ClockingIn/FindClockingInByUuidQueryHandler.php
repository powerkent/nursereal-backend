<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ClockingIn;

use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindClockingInByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ClockingInRepositoryInterface $clockingInRepository)
    {
    }

    final public function __invoke(FindClockingInByUuidQuery $query): ?ClockingIn
    {
        return $this->clockingInRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
