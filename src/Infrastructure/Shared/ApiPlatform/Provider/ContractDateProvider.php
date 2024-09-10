<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Exception\MissingQueryStringPropertyException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ContractDateResourceFactory;
use Symfony\Component\HttpFoundation\InputBag;
use function is_string;

/**
 * @extends AbstractProvider<Child, ContractDateResource>
 */
final class ContractDateProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ContractDateResourceFactory $contractDateResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?object
    {
        /** @var InputBag $query */
        /* @phpstan-ignore-next-line */
        $query = $context['request']->query;

        if (!is_string($child = $query->get('child'))) {
            throw new MissingQueryStringPropertyException(Child::class, 'child');
        }

        $childUuid = explode(':', $child)[0];

        return $this->queryBus->ask(new FindChildByUuidOrIdQuery(uuid: $childUuid));
    }

    /**
     * @param Child $model
     *
     * @return ContractDateResource
     */
    protected function toResource(object $model): object
    {
        return $this->contractDateResourceFactory->fromModel($model);
    }
}
