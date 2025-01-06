<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\NurseryStructure;

use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureOpeningRepositoryInterface;

final readonly class FindOpeningsByNurseryStructureQueryHandler implements QueryHandlerInterface
{
    public function __construct(private NurseryStructureOpeningRepositoryInterface $nurseryStructureOpeningRepository)
    {
    }

    /**
     * @return array<int, NurseryStructureOpening>|null
     */
    public function __invoke(FindOpeningsByNurseryStructureQuery $query): ?array
    {
        return $this->nurseryStructureOpeningRepository->searchByFilters(['nurseryStructure' => $query->nurseryStructure]);
    }
}
