<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindShiftTypeByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ShiftTypeRepositoryInterface $shiftTypeRepository)
    {
    }

    final public function __invoke(FindShiftTypeByUuidQuery $query): ?ShiftType
    {
        return $this->shiftTypeRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
