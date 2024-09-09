<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;

final readonly class FindTreatmentByChildrenQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TreatmentRepositoryInterface $treatmentRepository)
    {
    }

    /**
     * @return array<int, Treatment>|null
     */
    public function __invoke(FindTreatmentByChildrenQuery $query): ?array
    {
        if (empty($query->filters['childrenIds'])) {
            return $this->treatmentRepository->all();
        }

        return $this->treatmentRepository->searchByFilter($query->filters['childrenIds']);
    }
}
