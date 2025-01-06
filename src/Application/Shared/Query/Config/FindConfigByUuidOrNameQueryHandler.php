<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Config;

use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\ConfigRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindConfigByUuidOrNameQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ConfigRepositoryInterface $configRepository)
    {
    }

    final public function __invoke(FindConfigByUuidOrNameQuery $query): ?Config
    {
        if (null !== $query->name) {
            return $this->configRepository->searchOneByFilter(['name' => $query->name]);
        }

        if (null === $query->uuid) {
            return null;
        }

        return $this->configRepository->searchByUuid(
            $query->uuid instanceof UuidInterface
                ? $query->uuid
                : Uuid::fromString($query->uuid)
        );
    }
}
