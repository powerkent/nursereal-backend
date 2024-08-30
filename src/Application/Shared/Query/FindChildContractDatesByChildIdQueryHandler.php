<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

final readonly class FindChildContractDatesByChildIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    /**
     * @return array<int, ContractDate>|null
     */
    public function __invoke(FindChildContractDatesByChildIdQuery $query): ?array
    {
        return $this->childRepository->searchByFilter($query->childId);
    }
}
