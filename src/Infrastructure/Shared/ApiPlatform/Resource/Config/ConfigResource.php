<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Config;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ConfigInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Processor\ConfigProcessor;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Config\ConfigCollectionProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\Config\ConfigProvider;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Config',
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['config:list']],
            provider: ConfigCollectionProvider::class
        ),
        new Put(
            normalizationContext: ['groups' => ['config:item', 'config:put:read']],
            denormalizationContext: ['groups' => ['config:item', 'config:put:write']],
            security: "is_granted('".Roles::Manager->value."')",
            input: ConfigInput::class,
            provider: ConfigProvider::class,
            processor: ConfigProcessor::class,
        ),
    ]
)]
final class ConfigResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        #[Groups(['config:item', 'config:list'])]
        public UuidInterface $uuid,
        #[Groups(['config:item', 'config:list'])]
        public string $name,
        #[Groups(['config:item', 'config:list'])]
        public bool $value,
    ) {
    }
}
