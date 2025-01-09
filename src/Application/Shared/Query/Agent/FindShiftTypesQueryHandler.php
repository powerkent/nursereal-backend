<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;

final readonly class FindShiftTypesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ShiftTypeRepositoryInterface $shiftTypeRepository)
    {
    }

    /**
     * @return array<int, ShiftType>
     */
    public function __invoke(FindShiftTypesQuery $query): iterable
    {
        return $this->shiftTypeRepository->all();
    }
}
