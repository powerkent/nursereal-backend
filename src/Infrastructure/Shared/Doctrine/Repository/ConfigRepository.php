<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Config;
use Nursery\Domain\Shared\Repository\ConfigRepositoryInterface;

/**
 * @extends AbstractRepository<Config>
 */
class ConfigRepository extends AbstractRepository implements ConfigRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Config::class;
    }
}
