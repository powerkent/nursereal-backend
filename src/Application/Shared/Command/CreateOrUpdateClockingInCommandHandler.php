<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateClockingInCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClockingInRepositoryInterface $clockingInRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateClockingInCommand $command): ClockingIn
    {
        /** @var ?ClockingIn $clockingIn */
        $clockingIn = $this->clockingInRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null !== $clockingIn) {
            $clockingIn = $this->normalizer->denormalize($command->primitives, ClockingIn::class, context: ['object_to_populate' => $clockingIn, 'ignored_attributes' => ['agent', 'startDateTime', 'endDateTime']]);
            $clockingIn
                ->setAgent($command->primitives['agent'])
                ->setStartDateTime($command->primitives['startDateTime'])
                ->setEndDateTime($command->primitives['endDateTime']);

            return $this->clockingInRepository->update($clockingIn);
        }

        $clockingIn = new ClockingIn(...$command->primitives);

        return $this->clockingInRepository->save($clockingIn);
    }
}
