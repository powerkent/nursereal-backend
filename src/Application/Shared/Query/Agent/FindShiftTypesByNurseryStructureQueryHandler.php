<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;

final readonly class FindShiftTypesByNurseryStructureQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ShiftTypeRepositoryInterface $shiftTypeRepository)
    {
    }

    /**
     * @return array<int, ShiftType>|null
     */
    public function __invoke(FindShiftTypesByNurseryStructureQuery $query): ?array
    {
        return $this->shiftTypeRepository->searchShiftTypesByNurseryStructure($query->nurseryStructure);
    }
}
