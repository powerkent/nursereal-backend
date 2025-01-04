<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

final readonly class FindChildrenByNurseryStructureQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    /**
     * @return array<int, Child>|null
     */
    public function __invoke(FindChildrenByNurseryStructureQuery $query): ?array
    {
        return $this->childRepository->searchChildrenByNurseryStructure($query->nurseryStructure);
    }
}
