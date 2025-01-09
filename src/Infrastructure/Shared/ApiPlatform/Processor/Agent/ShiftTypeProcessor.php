<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\Agent\CreateOrUpdateShiftTypeCommand;
use Nursery\Application\Shared\Query\NurseryStructure\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Processor\ShiftTypeProcessorInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ShiftTypeInput;
use Ramsey\Uuid\UuidInterface;

final readonly class ShiftTypeProcessor implements ShiftTypeProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    public function process(ShiftTypeInput $data, UuidInterface $uuid): ShiftType
    {
        $nurseryStructures = [];
        foreach ($data->nurseryStructures as $nurseryStructure) {
            $nurseryStructures[] = $this->queryBus->ask(new FindNurseryStructureByUuidQuery($nurseryStructure->uuid));
        }

        $primitives = [
            'uuid' => $uuid,
            'name' => $data->name,
            'arrivalTime' => new DateTimeImmutable($data->arrivalTime),
            'endOfWorkTime' => new DateTimeImmutable($data->endOfWorkTime),
            'breakTime' => new DateTimeImmutable($data->breakTime),
            'endOfBreakTime' => new DateTimeImmutable($data->endOfBreakTime),
            'nurseryStructures' => $nurseryStructures,
        ];

        return $this->commandBus->dispatch(CreateOrUpdateShiftTypeCommand::create($primitives));
    }
}
