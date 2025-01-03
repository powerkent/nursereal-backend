<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Config;
use Nursery\Infrastructure\Shared\Foundry\Factory\ConfigFactory;

class ConfigFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        ConfigFactory::createOne();
    }

    protected static function modelClass(): string
    {
        return Config::class;
    }
}
