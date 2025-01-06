<?php

declare(strict_types=1);

namespace Config;

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
