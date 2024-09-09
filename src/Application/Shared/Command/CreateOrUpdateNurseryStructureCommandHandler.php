<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use DateTimeImmutable;
use DateTimeInterface;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateNurseryStructureCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NurseryStructureRepositoryInterface $nurseryStructureRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateNurseryStructureCommand $command): NurseryStructure
    {
        /** @var ?NurseryStructure $nurseryStructure */
        $nurseryStructure = $this->nurseryStructureRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null === $nurseryStructure) {
            $command->primitives['createdAt'] = new DateTimeImmutable();

            return $this->nurseryStructureRepository->save(new NurseryStructure(...$command->primitives));
        }

        if (isset($command->primitives['startAt']) && $command->primitives['startAt'] instanceof DateTimeInterface) {
            $command->primitives['startAt'] = $command->primitives['startAt']->format('c');
        }

        $nurseryStructure = $this->normalizer->denormalize($command->primitives, NurseryStructure::class, context: ['object_to_populate' => $nurseryStructure]);
        $nurseryStructure->setUpdatedAt(new DateTimeImmutable());

        return $this->nurseryStructureRepository->update($nurseryStructure);
    }
}
