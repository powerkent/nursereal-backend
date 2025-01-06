<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\NurseryStructure;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindNurseryStructureByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private NurseryStructureRepositoryInterface $nurseryStructureRepository)
    {
    }

    final public function __invoke(FindNurseryStructureByUuidQuery $query): ?NurseryStructure
    {
        return $this->nurseryStructureRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
