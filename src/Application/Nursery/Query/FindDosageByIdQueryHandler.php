<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Dosage;
use Nursery\Domain\Nursery\Repository\DosageRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindDosageByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private DosageRepositoryInterface $dosageRepository)
    {
    }

    final public function __invoke(FindDosageByIdQuery $query): ?Dosage
    {
        return $this->dosageRepository->search($query->id);
    }
}
