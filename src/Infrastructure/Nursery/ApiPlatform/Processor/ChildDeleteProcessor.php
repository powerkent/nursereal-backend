<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Nursery\Command\DeleteChildByUuidQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;

final class ChildDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->commandBus->dispatch(new DeleteChildByUuidQuery($uriVariables['uuid']));
    }
}
