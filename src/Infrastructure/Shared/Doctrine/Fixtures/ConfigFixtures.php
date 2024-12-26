<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nursery\Infrastructure\Shared\Foundry\Factory\ConfigFactory;

class ConfigFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ConfigFactory::createOne([
            'name' => 'AGENT_LOGIN_WITH_PHONE',
            'value' => true,
        ]);
    }
}
