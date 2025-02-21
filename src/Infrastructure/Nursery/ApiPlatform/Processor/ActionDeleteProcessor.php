<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Nursery\Command\Action\DeleteActionByUuidCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;

/**
 * @implements ProcessorInterface<null, boolean>
 */
final readonly class ActionDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        return $this->commandBus->dispatch(new DeleteActionByUuidCommand($uriVariables['uuid']));
    }
}
