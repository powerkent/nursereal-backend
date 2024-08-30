<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;
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
            throw new EntityNotFoundException(Treatment::class, 'id', $command->id());
        }

        $child = $this->queryBus->ask(new FindChildByUuidOrIdQuery($treatment->getChild()->getUuid()));
        $this->commandBus->dispatch(new DeleteTreatmentByUuidQuery($treatment->getUuid()));

        $command->primitives['child'] = $child;

        return $this->commandBus->dispatch(CreateTreatmentCommand::create($command->primitives['child']));
    }
}
