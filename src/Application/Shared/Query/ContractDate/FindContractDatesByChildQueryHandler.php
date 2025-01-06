<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ContractDate;

use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class FindContractDatesByChildQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContractDateRepositoryInterface $contractDateRepository)
    {
    }

    /**
     * @return array<int, ContractDate>|null
     */
    public function __invoke(FindContractDatesByChildQuery $query): ?array
    {
        return $this->contractDateRepository->searchByFilters(['child' => $query->child]);
    }
}
