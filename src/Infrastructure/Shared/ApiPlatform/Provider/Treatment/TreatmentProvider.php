<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Treatment;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\Treatment\FindTreatmentByUuidQuery;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Treatment\TreatmentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Treatment\TreatmentResourceFactory;

/**
 * @extends AbstractProvider<Treatment, TreatmentResource>
 */
final class TreatmentProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly TreatmentResourceFactory $treatmentResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        return $this->queryBus->ask(new FindTreatmentByUuidQuery($uriVariables['uuid']));
    }

    protected function toResource(object $model): object
    {
        return $this->treatmentResourceFactory->fromModel($model);
    }
}
