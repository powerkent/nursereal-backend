<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

use Model\Activity;
use Nursery\Domain\Shared\Repository\ActivityRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateActivityCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateActivityCommand $command): Activity
    {
        $activity = $this->activityRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null !== $activity) {
            $activity = $this->normalizer->denormalize($command->primitives, Activity::class, context: ['object_to_populate' => $activity]);

            return $this->activityRepository->update($activity);
        }

        return $this->activityRepository->save(new Activity(...$command->primitives));
    }
}
