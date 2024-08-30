<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindChildByUuidOrIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ChildRepositoryInterface $childRepository)
    {
    }

    final public function __invoke(FindChildByUuidOrIdQuery $query): ?Child
    {
        if (null !== $query->id) {
            return $this->childRepository->search($query->id);
        }

        if (null === $query->uuid) {
            return null;
        }

        return $this->childRepository->searchByUuid(
            $query->uuid instanceof UuidInterface
            ? $query->uuid
            : Uuid::fromString($query->uuid)
        );
    }
}
