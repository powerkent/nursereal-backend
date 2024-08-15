<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Nursery\Repository\ActivityRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindActivityByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActivityRepositoryInterface $activityRepository)
    {
    }

    final public function __invoke(FindActivityByUuidQuery $query): ?Activity
    {
        return $this->activityRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
