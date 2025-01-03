<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\FindConfigsQuery;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ConfigResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ConfigResourceFactory;

/**
 * @extends AbstractCollectionProvider<Config, ConfigResource>
 */
final class ConfigCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ConfigResourceFactory $configResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindConfigsQuery());
    }

    protected function toResource($model): object
    {
        return $this->configResourceFactory->fromModel($model);
    }
}
