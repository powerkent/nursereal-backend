<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query\Action;

use Exception;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindActionByTypeQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActionRepositoryInterface $actionRepository)
    {
    }

    /**
     * @return array<int, Action>
     *
     * @throws Exception
     */
    final public function __invoke(FindActionByTypeQuery $query): array
    {
        return $this->actionRepository->searchByType($query->type);
    }
}
