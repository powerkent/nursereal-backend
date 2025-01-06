<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Nursery\Application\Shared\Command\ContractDate\DeleteContractDateByIdsCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\MissingPropertyException;
use Symfony\Component\HttpFoundation\Request;

final readonly class ContractDateDeleteAction
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['contractDateIds'])) {
            throw new MissingPropertyException(self::class, 'contractDateIds');
        }

        $this->commandBus->dispatch(new DeleteContractDateByIdsCommand($data['contractDateIds']));
    }
}
