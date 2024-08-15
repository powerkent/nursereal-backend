<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\ActivityRepositoryInterface;
use Ramsey\Uuid\Uuid;
use function is_string;

final readonly class DeleteActivityByUuidQueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
    ) {
    }

    public function __invoke(DeleteActivityByUuidQuery $command): bool
    {
        $activity = $this->activityRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $activity) {
            throw new EntityNotFoundException(sprintf('unable to find the activity you want to delete. uuid : %s', $command->uuid));
        }

        $this->activityRepository->delete($activity);

        return true;
    }
}
