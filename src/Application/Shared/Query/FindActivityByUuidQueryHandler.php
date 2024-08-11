<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Activity;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
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
