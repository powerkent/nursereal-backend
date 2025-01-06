<?php

declare(strict_types=1);

namespace ClockingIn;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Application\Shared\Query\ClockingIn\FindClockInsByFiltersQuery;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;

/**
 * @extends AbstractCollectionProvider<ClockingIn, ClockingInResource>
 */
final class ClockingInCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ClockingInResourceFactory $clockingInResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     * @throws DateMalformedStringException
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        if (null !== $nurseryStructures = ($context['filters']['nursery_structures'] ?? null)) {
            $filters['nurseryStructures'] = $nurseryStructures;
        }

        $filters['startDateTime'] = new DateTimeImmutable($context['filters']['start_date_time']);
        if (null === ($context['filters']['end_date_time'] ?? null)) {
            $filters['endDateTime'] = $filters['startDateTime']->setTime(23, 59, 59);
        } else {
            $filters['endDateTime'] = new DateTimeImmutable($context['filters']['end_date_time']);
        }

        $filters = array_combine(
            array_map('strval', array_keys($filters)),
            $filters
        );

        return $this->queryBus->ask(new FindClockInsByFiltersQuery($filters));
    }

    protected function toResource($model): object
    {
        return $this->clockingInResourceFactory->fromModel($model);
    }
}
