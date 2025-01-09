<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateShiftTypeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ShiftTypeRepositoryInterface $shiftTypeRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateShiftTypeCommand $command): ShiftType
    {
        /** @var ?ShiftType $shiftType */
        $shiftType = $this->shiftTypeRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null !== $shiftType) {
            $shiftType = $this->normalizer->denormalize($command->primitives, ShiftType::class, context: ['object_to_populate' => $shiftType]);

            return $this->shiftTypeRepository->update($shiftType);
        }

        $shiftType = new ShiftType(...$command->primitives);

        return $this->shiftTypeRepository->save($shiftType);
    }
}
