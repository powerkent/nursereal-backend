<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;
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
