<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\AgeGroup;

use Nursery\Domain\Shared\Model\AgeGroup;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AgeGroupRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgeGroupByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AgeGroupRepositoryInterface $ageGroupRepository)
    {
    }

    final public function __invoke(FindAgeGroupByUuidQuery $query): ?AgeGroup
    {
        return $this->ageGroupRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
