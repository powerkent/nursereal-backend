<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Dosage;

use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\DosageRepositoryInterface;

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
