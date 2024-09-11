<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class FindContractDatesByDateQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ContractDateRepositoryInterface $contractDateRepository)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function __invoke(FindContractDatesByDateQuery $query): array
    {
        return $this->contractDateRepository->searchByDate($query->child, $query->start);
    }
}
