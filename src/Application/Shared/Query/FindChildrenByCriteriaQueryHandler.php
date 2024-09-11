<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

final readonly class FindChildrenByCriteriaQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    /**
     * @return array<int, Child>
     */
    public function __invoke(FindChildrenByCriteriaQuery $query): iterable
    {
        return $this->childRepository->searchByCriteria($query->criteria);
    }
}
