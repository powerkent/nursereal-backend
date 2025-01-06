<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Config;

use Nursery\Domain\Shared\Model\Config;

final readonly class ConfigResourceFactory
{
    public function fromModel(Config $config): ConfigResource
    {
        return new ConfigResource(
            uuid: $config->getUuid(),
            name: $config->getName(),
            value: $config->getValue(),
        );
    }
}
