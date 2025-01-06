<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Treatment;

use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
