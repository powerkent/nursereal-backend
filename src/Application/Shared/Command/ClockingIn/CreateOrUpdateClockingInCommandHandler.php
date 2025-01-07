<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ClockingIn;

use Nursery\Application\Shared\Query\NurseryStructure\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Event\Created;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Enum\ClockingInState;
use Nursery\Domain\Shared\Event\EventBusInterface;
use Nursery\Domain\Shared\Event\Updated;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateClockingInCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ClockingInRepositoryInterface $clockingInRepository,
        private QueryBusInterface $queryBus,
        private EventBusInterface $eventBus,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateClockingInCommand $command): ClockingIn
    {
        /** @var ?ClockingIn $clockingIn */
        $clockingIn = $this->clockingInRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);
        $nurseryStructure = $this->queryBus->ask(new FindNurseryStructureByUuidQuery($command->primitives['nurseryStructureUuid']));
        unset($command->primitives['nurseryStructureUuid']);
        $command->primitives['nurseryStructure'] = $nurseryStructure;

        if (null !== $clockingIn) {
            $clockingIn = $this->normalizer->denormalize($command->primitives, ClockingIn::class, context: ['object_to_populate' => $clockingIn, 'ignored_attributes' => ['agent', 'startDateTime', 'endDateTime', 'nurseryStructure']]);
            $clockingIn
                ->setState($clockingIn->getState())
                ->setNurseryStructure($nurseryStructure)
                ->setAgent($command->primitives['agent'])
                ->setStartDateTime($command->primitives['startDateTime'])
                ->setEndDateTime($command->primitives['endDateTime']);

            $clockingIn = $this->clockingInRepository->update($clockingIn);

            $this->eventBus->publish(new Updated($clockingIn->getUuid()));

            return $clockingIn;
        }

        $command->primitives['state'] = ClockingInState::New;
        $clockingIn = new ClockingIn(...$command->primitives);

        $clockingIn = $this->clockingInRepository->save($clockingIn);

        $this->eventBus->publish(new Created($clockingIn->getUuid()));

        return $clockingIn;
    }
}
