<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\NurseryStructure;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\NurseryStructure\DeleteNurseryStructureByUuidCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;

/**
 * @implements ProcessorInterface<null, boolean>
 */
final readonly class NurseryStructureDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $this->commandBus->dispatch(new DeleteNurseryStructureByUuidCommand($uriVariables['uuid']));
    }
}
