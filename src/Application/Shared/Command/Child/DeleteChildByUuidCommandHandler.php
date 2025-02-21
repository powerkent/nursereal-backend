<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Child;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteChildByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(DeleteChildByUuidCommand $command): bool
    {
        $child = $this->childRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $child) {
            throw new EntityNotFoundException(Child::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->childRepository->delete($child);

        return true;
    }
}
