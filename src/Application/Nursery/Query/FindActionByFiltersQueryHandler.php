<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\AbstractAction;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Nursery\Repository\AbstractActionRepositoryInterface;

final readonly class FindActionByFiltersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AbstractActionRepositoryInterface $actionRepository)
    {
    }

    /**
     * @return array<int, AbstractAction>|null
     */
    public function __invoke(FindActionByFiltersQuery $query): ?array
    {
        return $this->actionRepository->searchByFilters($query->filters);
    }
}
