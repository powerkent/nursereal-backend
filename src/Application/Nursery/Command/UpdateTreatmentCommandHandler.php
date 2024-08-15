<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdateTreatmentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private TreatmentRepositoryInterface $treatmentRepository,
    ) {
    }

    public function __invoke(UpdateTreatmentCommand $command): Treatment
    {
        $treatment = $command->id() instanceof UuidInterface ? $this->treatmentRepository->searchByUuid($command->id()) : $this->treatmentRepository->search($command->id());

        if (null === $treatment || null === $treatment->getChild()) {
            throw new EntityNotFoundException(Treatment::class);
        }

        $child = $this->queryBus->ask(new FindChildByUuidQuery($treatment->getChild()->getUuid()));
        $this->commandBus->dispatch(new DeleteTreatmentByUuidQuery($treatment->getUuid()));

        $command->primitives['child'] = $child;

        return $this->commandBus->dispatch(CreateTreatmentCommand::create($command->primitives['child']));
    }
}
