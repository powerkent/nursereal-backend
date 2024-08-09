<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Query;

use Model\Activity;
use Nursery\Infrastructure\Shared\Doctrine\Repository\ActivityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindActivityByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActivityRepository $activityRepository)
    {
    }

    final public function __invoke(FindActivityByUuidQuery $query): ?Activity
    {
        return $this->activityRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
