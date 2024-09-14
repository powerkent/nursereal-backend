<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Nursery\Infrastructure\Shared\Foundry\AgentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nursery\Infrastructure\Shared\Foundry\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\CustomerFactory;
use Nursery\Infrastructure\Shared\Foundry\NurseryStructureFactory;

class ChildFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        NurseryStructureFactory::createMany(2);
        AgentFactory::createMany(6);
        CustomerFactory::createMany(10);
        ChildFactory::createMany(10);
        $manager->flush();
    }
}
