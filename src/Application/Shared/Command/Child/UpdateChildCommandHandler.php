<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Child;

use DateTimeImmutable;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Model\IRP;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdateChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(UpdateChildCommand $command): Child
    {
        /** @var ?Child $child */
        $child = $command->id() instanceof UuidInterface ? $this->childRepository->searchByUuid($command->id()) : $this->childRepository->search($command->id());

        if (null === $child) {
            throw new EntityNotFoundException(Child::class, 'id', $command->id());
        }

        $child->setFirstname($command->primitives['firstname']);
        $child->setLastname($command->primitives['lastname']);
        $child->setBirthday($command->primitives['birthday']);
        $child->setGender($command->primitives['gender']);
        $child->setAgeGroup($command->primitives['ageGroup'] ?? null);
        $child->setIsWalking($command->primitives['isWalking']);
        $child->setFamily($command->primitives['family'] ?? null);
        $child->setCreatedAt($child->getCreatedAt());
        $child->setUpdatedAt(new DateTimeImmutable());

        if (!empty($command->primitives['irp'])) {
            $child->setIrp(new IRP(...$command->primitives['irp']));
        } else {
            $child->setIrp(null);
        }

        if (!empty($child->getTreatments())) {
            foreach ($child->getTreatments() as $existingTreatment) {
                $child->removeTreatment($existingTreatment);
            }
        }

        if (!empty($command->primitives['treatments'])) {
            foreach ($command->primitives['treatments'] as $treatment) {
                $child->addTreatment($treatment);
            }
        }

        if (!empty($command->primitives['contractDates'])) {
            foreach ($command->primitives['contractDates'] as $contractDate) {
                $child->addContractDate(new ContractDate(...$contractDate));
            }
        }

        return $this->childRepository->update($child);
    }
}
