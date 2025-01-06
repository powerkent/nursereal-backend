<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query\Activity;

use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Nursery\Repository\ActivityRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindActivitiesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActivityRepositoryInterface $activityRepository)
    {
    }

    /**
     * @return array<int, Activity>
     */
    public function __invoke(FindActivitiesQuery $query): iterable
    {
        return $this->activityRepository->all();
    }
}
