<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use DateTimeImmutable;
use Exception;
use Nursery\Application\Nursery\Command\CreateChildCommand;
use Nursery\Application\Nursery\Command\CreateDosageCommand;
use Nursery\Application\Nursery\Command\CreateTreatmentCommand;
use Nursery\Application\Nursery\Command\UpdateChildCommand;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Processor\ChildProcessorInterface;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ChildInput;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class ChildProcessor implements ChildProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
    ) {
    }

    /**
     * @throws Exception
     */
    public function process(ChildInput $data, UuidInterface $uuid): Child
    {
        $primitives = [
            'uuid' => $uuid,
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'birthday' => new DateTimeImmutable($data->birthday),
            'createdAt' => $createdAt = new DateTimeImmutable(),
            'treatments' => [],
        ];

        if (null !== $data->irp) {
            $primitives['irp'] = [
                'name' => $data->irp->name,
                'description' => $data->irp->description,
                'createdAt' => $createdAt,
                'startAt' => new DateTimeImmutable($data->irp->startAt),
                'endAt' => null !== $data->irp->endAt ? new DateTimeImmutable($data->irp->endAt) : null,
            ];
        }

        $child = $this->createOrUpdateChild($primitives);

        unset($primitives);
        $primitives = [
            'uuid' => $child->getUuid(),
            'treatments' => [],
        ];
        if (isset($data->treatments) && count($data->treatments)) {
            foreach ($data->treatments as $newTreatment) {
                $treatmentArray = [
                    'uuid'        => Uuid::uuid4(),
                    'child'       => $child,
                    'name'        => $newTreatment->name,
                    'description' => $newTreatment->description,
                    'createdAt'   => $createdAt,
                    'startAt'     => new DateTimeImmutable($newTreatment->startAt),
                    'endAt'       => null !== $newTreatment->endAt ? new DateTimeImmutable($newTreatment->endAt) : null,
                ];

                /** @var Treatment $treatmentObject */
                $treatmentObject = $this->commandBus->dispatch(CreateTreatmentCommand::create($treatmentArray));

                if (isset($newTreatment->dosages) && count($newTreatment->dosages)) {
                    foreach ($newTreatment->dosages as $newDosage) {
                        $dosageArray = [
                            'treatment'  => $treatmentObject,
                            'dose'       => $newDosage->dose,
                            'dosingDate' => null !== $newDosage->dosingDate ? new DateTimeImmutable($newDosage->dosingDate) : null,
                        ];

                        $treatmentObject->addDosage($this->commandBus->dispatch(CreateDosageCommand::create($dosageArray)));
                    }
                }

                $primitives['treatments'][] = $treatmentObject;
            }
        }

        return $this->commandBus->dispatch(UpdateChildCommand::create($primitives));
    }

    /**
     * @param array<string, mixed> $primitives
     */
    private function createOrUpdateChild(array $primitives): Child
    {
        $command = (null === $this->queryBus->ask(new FindChildByUuidQuery($primitives['uuid'])))
            ? CreateChildCommand::create($primitives)
            : UpdateChildCommand::create($primitives)
        ;

        return $this->commandBus->dispatch($command);
    }
}
