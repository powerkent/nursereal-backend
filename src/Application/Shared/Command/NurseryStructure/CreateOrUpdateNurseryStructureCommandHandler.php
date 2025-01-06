<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\NurseryStructure;

use DateTimeImmutable;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Repository\NurseryStructureOpeningRepositoryInterface;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateNurseryStructureCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NurseryStructureRepositoryInterface $nurseryStructureRepository,
        private NurseryStructureOpeningRepositoryInterface $nurseryStructureOpeningRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateNurseryStructureCommand $command): NurseryStructure
    {
        /** @var ?NurseryStructure $nurseryStructure */
        $nurseryStructure = $this->nurseryStructureRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        $nurseryStructureOpenings = $command->primitives['openings'];
        unset($command->primitives['openings']);
        if (null === $nurseryStructure) {
            $command->primitives['createdAt'] = new DateTimeImmutable();
            $nurseryStructure = $this->nurseryStructureRepository->save(new NurseryStructure(...$command->primitives));
            $this->setNurseryStructureOpenings($nurseryStructure, $nurseryStructureOpenings);

            return $this->nurseryStructureRepository->update($nurseryStructure);
        }
        $nurseryStructure = $this->setNurseryStructureOpenings($nurseryStructure, $nurseryStructureOpenings);
        $nurseryStructure = $this->normalizer->denormalize($command->primitives, NurseryStructure::class, context: ['object_to_populate' => $nurseryStructure]);
        $nurseryStructure->setUpdatedAt(new DateTimeImmutable());

        return $this->nurseryStructureRepository->update($nurseryStructure);
    }

    /**
     * @param array<string, mixed> $nurseryStructureOpenings
     */
    private function setNurseryStructureOpenings(NurseryStructure $nurseryStructure, array $nurseryStructureOpenings): NurseryStructure
    {
        if (!$nurseryStructure->getNurseryStructureOpenings()->isEmpty()) {
            foreach ($nurseryStructure->getNurseryStructureOpenings() as $opening) {
                $nurseryStructure->removeNurseryStructureOpening($opening);
                $this->nurseryStructureOpeningRepository->delete($opening);
            }
        }

        foreach ($nurseryStructureOpenings as $opening) {
            $nurseryStructureOpening = new NurseryStructureOpening(...$opening);
            $nurseryStructure->addNurseryStructureOpening($nurseryStructureOpening);
            $nurseryStructureOpening->setNurseryStructure($nurseryStructure);
        }

        return $nurseryStructure;
    }
}
