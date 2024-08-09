<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindTreatmentByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TreatmentRepositoryInterface $treatmentRepository)
    {
    }

    final public function __invoke(FindTreatmentByUuidQuery $query): ?Treatment
    {
        return $this->treatmentRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
