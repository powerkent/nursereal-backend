<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Repository\ConfigRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdateConfigCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ConfigRepositoryInterface $configRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(UpdateConfigCommand $command): Config
    {
        /** @var Config $config */
        $config = $this->configRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);
        $config = $this->normalizer->denormalize($command->primitives, Config::class, context: ['object_to_populate' => $config]);

        return $this->configRepository->update($config);

    }
}
