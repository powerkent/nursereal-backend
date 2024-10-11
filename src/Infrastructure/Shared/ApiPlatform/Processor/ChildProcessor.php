<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use DateTimeImmutable;
use Exception;
use Nursery\Application\Shared\Command\CreateChildCommand;
use Nursery\Application\Shared\Command\CreateDosageCommand;
use Nursery\Application\Shared\Command\CreateTreatmentCommand;
use Nursery\Application\Shared\Command\UpdateChildCommand;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Processor\ChildProcessorInterface;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\TreatmentPayload;
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
     * @param  ChildInput $data
     * @throws Exception
     */
    public function process($data, UuidInterface $uuid): Child
    {
        $createdAt = new DateTimeImmutable();
        $primitives = [
            'uuid' => $uuid,
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'birthday' => new DateTimeImmutable($data->birthday),
            'nurseryStructure' => $this->queryBus->ask(new FindNurseryStructureByUuidQuery($data->nurseryStructureUuid)),
            'treatments' => [],
        ];

        $irp = null;
        if (null !== $data->irp) {
            $primitives['irp'] = $irp = [
                'name' => $data->irp->name,
                'description' => $data->irp->description,
                'createdAt' => $createdAt,
                'startAt' => new DateTimeImmutable($data->irp->startAt),
                'endAt' => null !== $data->irp->endAt ? new DateTimeImmutable($data->irp->endAt) : null,
            ];
        }

        /** @var Child $child */
        [$child, $command] = $this->createOrUpdateChild($primitives);

        if ($command instanceof CreateChildCommand && empty($data->treatments)) {
            return $child;
        }

        $primitives = [
            'uuid' => $child->getUuid(),
            'irp' => $irp,
            'treatments' => [],
        ];
        if (isset($data->treatments) && count($data->treatments)) {
            foreach ($data->treatments as $treatment) {
                $primitives['treatments'][] = $this->createTreatment($child, $treatment);
            }
        }

        return $this->commandBus->dispatch(UpdateChildCommand::create($primitives));
    }

    public function createTreatment(Child $child, TreatmentPayload $treatment): Treatment
    {
        $treatmentArray = [
            'uuid'        => Uuid::uuid4(),
            'child'       => $child,
            'name'        => $treatment->name,
            'description' => $treatment->description,
            'createdAt'   => new DateTimeImmutable(),
            'startAt'     => new DateTimeImmutable($treatment->startAt),
            'endAt'       => null !== $treatment->endAt ? new DateTimeImmutable($treatment->endAt) : null,
        ];

        /** @var Treatment $treatmentObject */
        $treatmentObject = $this->commandBus->dispatch(CreateTreatmentCommand::create($treatmentArray));

        if (isset($treatment->dosages) && count($treatment->dosages)) {
            foreach ($treatment->dosages as $treatment) {
                $dosageArray = [
                    'treatment'  => $treatmentObject,
                    'dose'       => $treatment->dose,
                    'dosingTime' => null !== $treatment->dosingTime ? new DateTimeImmutable($treatment->dosingTime) : null,
                ];

                $treatmentObject->addDosage($this->commandBus->dispatch(CreateDosageCommand::create($dosageArray)));
            }
        }

        return $treatmentObject;
    }

    /**
     * @param  array<string, mixed> $primitives
     * @return array<int, mixed>
     */
    private function createOrUpdateChild(array $primitives): array
    {
        $command = (null === $this->queryBus->ask(new FindChildByUuidOrIdQuery($primitives['uuid'])))
            ? CreateChildCommand::create($primitives)
            : UpdateChildCommand::create($primitives)
        ;

        return [$this->commandBus->dispatch($command), $command];
    }
}
