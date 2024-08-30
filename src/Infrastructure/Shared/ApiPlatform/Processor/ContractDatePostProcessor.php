<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\PersistChildCommand;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Exception\MissingQueryStringPropertyException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ContractDateInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\ContractDatePayload;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResourceFactory;
use Symfony\Component\HttpFoundation\InputBag;
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
        /** @var InputBag $query */
        /* @phpstan-ignore-next-line */
        $query = $context['request']->query;

        if (!is_string($child = $query->get('child'))) {
            throw new MissingQueryStringPropertyException(Child::class, 'child');
        }
        $childId = (int) explode(':', $child)[0];

        $child = $this->queryBus->ask(new FindChildByUuidOrIdQuery(id: $childId));

        if (null === $child) {
            throw new EntityNotFoundException(Child::class, $childId);
        }

        $contractDates = array_map(function (ContractDatePayload $contractDatePayload) use ($child) {
            return new ContractDate(
                contractTimeStart: $contractDatePayload->contractTimeStart,
                contractTimeEnd: $contractDatePayload->contractTimeEnd,
                child: $child,
            );
        }, $data->contractDates);

        $child = $this->commandBus->dispatch(new PersistChildCommand($child));

        return $this->childCalendarEntryResourceFactory->fromModel($child);
    }
}
