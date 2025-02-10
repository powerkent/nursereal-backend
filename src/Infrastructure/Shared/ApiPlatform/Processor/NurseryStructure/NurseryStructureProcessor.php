<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructure;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\Address\CreateOrUpdateAddressCommand;
use Nursery\Application\Shared\Command\Agent\CreateOrUpdateAgentCommand;
use Nursery\Application\Shared\Command\NurseryStructure\CreateOrUpdateNurseryStructureCommand;
use Nursery\Application\Shared\Query\Agent\FindAgentsByNurseryStructureQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructure\NurseryStructureResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<NurseryStructureInput, NurseryStructureResource>
 */
final readonly class NurseryStructureProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    /**
     * @param  NurseryStructureInput        $data
     * @throws DateMalformedStringException
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): NurseryStructureResource
    {
        $address = $this->commandBus->dispatch(CreateOrUpdateAddressCommand::create([
            'id' => $data->address->id,
            'address' => $data->address->address,
            'zipcode' => $data->address->zipcode,
            'city' => $data->address->city,
        ]));

        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'address' => $address,
        ];

        foreach ($data->openings as $opening) {
            $primitives['openings'][] = [
                'openingHour' => new DateTimeImmutable($opening->openingHour),
                'closingHour' => new DateTimeImmutable($opening->closingHour),
                'openingDay' => OpeningDays::from($opening->openingDay),
            ];
        }

        $nurseryStructure = $this->commandBus->dispatch(CreateOrUpdateNurseryStructureCommand::create($primitives));

        if (isset($data->user) && isset($data->password)) {
            $agents = $this->queryBus->ask(new FindAgentsByNurseryStructureQuery($nurseryStructure));
            $primitives = [
                'uuid' => empty($agents) ? Uuid::uuid4() : $agents[0]->getUuid(),
                'avatar' => null,
                'firstname' => null,
                'lastname' => null,
                'email' => null,
                'user' => $data->user,
                'password' => $data->password,
                'createdAt' => empty($agents) ? new DateTimeImmutable() : $agents[0]->getCreatedAt(),
                'updatedAt' => empty($agents) ? null : new DateTimeImmutable(),
                'nurseryStructures' => [$nurseryStructure->getUuid()],
            ];

            $this->commandBus->dispatch(CreateOrUpdateAgentCommand::create($primitives));
        }

        return $this->nurseryStructureResourceFactory->fromModel($nurseryStructure);
    }
}
