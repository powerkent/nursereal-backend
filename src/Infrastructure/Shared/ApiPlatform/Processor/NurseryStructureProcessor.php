<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\CreateOrUpdateNurseryStructureCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<NurseryStructureInput, NurseryStructureResource>
 */
final readonly class NurseryStructureProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    /**
     * @param NurseryStructureInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): NurseryStructureResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'address' => $data->address,
        ];
        foreach ($data->openings as $opening) {
            $primitives['openings'][] = [
                'openingHour' => new DateTimeImmutable($opening->openingHour),
                'closingHour' => new DateTimeImmutable($opening->closingHour),
                'openingDay' => OpeningDays::from($opening->openingDay),
            ];
        }

        $nurseryStructure = $this->commandBus->dispatch(CreateOrUpdateNurseryStructureCommand::create($primitives));

        return $this->nurseryStructureResourceFactory->fromModel($nurseryStructure);
    }
}
