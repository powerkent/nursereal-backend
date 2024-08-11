<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Activity;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ActivityRepositoryInterface;

final readonly class FindActivityQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActivityRepositoryInterface $activityRepository)
    {
    }

    /**
     * @return array<int, Activity>
     */
    public function __invoke(FindActivityQuery $query): iterable
    {
        return $this->activityRepository->all();
    }
}
