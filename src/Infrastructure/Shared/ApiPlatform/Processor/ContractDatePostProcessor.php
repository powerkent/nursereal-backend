<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\DeleteContractDateByIdCommand;
use Nursery\Application\Shared\Command\PersistChildCommand;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Application\Shared\Query\FindContractDatesByDateQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ContractDateInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResourceFactory;
use Throwable;

/**
 * @implements ProcessorInterface<ContractDateInput, ContractDateResource>
 */
final class ContractDatePostProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ContractDateResourceFactory $childCalendarEntryResourceFactory,
    ) {
    }

    /**
     * @param  ContractDateInput $data
     * @throws Throwable
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ContractDateResource
    {
        /** @var ?Child $child */
        $child = $this->queryBus->ask(new FindChildByUuidOrIdQuery(uuid: $data->childUuid));

        if (null === $child) {
            throw new EntityNotFoundException(Child::class, $data->childUuid);
        }

        $contractDates = [];
        foreach ($data->contractDates as $contractDate) {
            $contractDateExists = $this->queryBus->ask(new FindContractDatesByDateQuery($child, $contractDate->contractTimeStart));
            if ([] !== $contractDateExists) {
                foreach ($contractDateExists as $contractDateExist) {
                    $this->commandBus->dispatch(new DeleteContractDateByIdCommand($contractDateExist['id']));
                }
            }

            $contractDates[] = new ContractDate(
                contractTimeStart: $contractDate->contractTimeStart,
                contractTimeEnd: $contractDate->contractTimeEnd,
                child: $child,
            );
        }

        $child->setContractDates($contractDates);

        $child = $this->commandBus->dispatch(new PersistChildCommand($child));

        return $this->childCalendarEntryResourceFactory->fromModel($child);
    }
}
