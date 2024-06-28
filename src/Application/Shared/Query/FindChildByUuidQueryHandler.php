<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\ChildRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindChildByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepository $repository)
    {
    }

    final public function __invoke(FindChildByUuidQuery $query): ?Child
    {
        return $this->repository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
