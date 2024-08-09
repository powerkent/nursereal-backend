<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindChildByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    final public function __invoke(FindChildByUuidQuery $query): ?Child
    {
        return $this->childRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
