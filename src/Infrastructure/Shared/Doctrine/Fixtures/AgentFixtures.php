<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;

class AgentFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        AgentFactory::createMany(15);
    }

    protected static function modelClass(): string
    {
        return Agent::class;
    }

    public function getDependencies(): array
    {
        return [
            NurseryStructureFixtures::class,
        ];
    }
}
