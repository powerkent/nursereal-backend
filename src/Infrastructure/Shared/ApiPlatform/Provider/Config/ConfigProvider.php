<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Config;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Config\FindConfigByUuidOrNameQuery;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Config\ConfigResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Config\ConfigResourceFactory;

/**
 * @extends AbstractProvider<Config, ConfigResource>
 */
final class ConfigProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ConfigResourceFactory $configResourceFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Config
    {
        return $this->queryBus->ask(new FindConfigByUuidOrNameQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Config $model
     *
     * @return ConfigResource
     */
    protected function toResource(object $model): object
    {
        return $this->configResourceFactory->fromModel($model);
    }
}