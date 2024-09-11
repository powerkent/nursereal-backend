<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\DeleteTreatmentByUuidCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;

/**
 * @implements ProcessorInterface<null, boolean>
 */
final readonly class TreatmentDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $this->commandBus->dispatch(new DeleteTreatmentByUuidCommand($uriVariables['uuid']));
    }
}
