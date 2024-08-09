<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindChildrenQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    /**
     * @return array<int, Child>
     */
    public function __invoke(FindChildrenQuery $query): iterable
    {
        return $this->childRepository->all();
    }
}
