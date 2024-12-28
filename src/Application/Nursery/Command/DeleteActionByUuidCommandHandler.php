<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteActionByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActionRepositoryInterface $actionRepository,
    ) {
    }

    public function __invoke(DeleteActionByUuidCommand $command): bool
    {
        $action = $this->actionRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $action) {
            throw new EntityNotFoundException(Child::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->actionRepository->delete($action);

        return true;
    }
}
