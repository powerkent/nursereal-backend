<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindTreatmentByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TreatmentRepositoryInterface $treatmentRepository)
    {
    }

    final public function __invoke(FindTreatmentByIdQuery $query): ?Treatment
    {
        if (null === $query->id) {
            return null;
        }

        return $this->treatmentRepository->search($query->id);
    }
}
