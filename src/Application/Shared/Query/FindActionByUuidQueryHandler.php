<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Query;

use Model\Activity;
use Nursery\Domain\Shared\Repository\ActionRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindActionByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActionRepositoryInterface $actionRepository)
    {
    }

    final public function __invoke(FindActivityByUuidQuery $query): ?Activity
    {
        return $this->actionRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
