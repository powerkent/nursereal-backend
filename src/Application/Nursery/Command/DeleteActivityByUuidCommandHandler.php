<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Nursery\Repository\ActivityRepositoryInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use function is_string;

final readonly class DeleteActivityByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
    ) {
    }

    public function __invoke(DeleteActivityByUuidCommand $command): bool
    {
        $activity = $this->activityRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $activity) {
            throw new EntityNotFoundException(Activity::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->activityRepository->delete($activity);

        return true;
    }
}
