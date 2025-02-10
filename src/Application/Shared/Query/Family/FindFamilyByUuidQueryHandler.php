<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Family;

use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindFamilyByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private FamilyRepositoryInterface $familyRepository)
    {
    }

    final public function __invoke(FindFamilyByUuidQuery $query): ?Family
    {
        return $this->familyRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
