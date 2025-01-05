<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Infrastructure\Shared\Foundry\Factory\ClockingInFactory;

class ClockingInFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ClockingInFactory::createMany(80);
    }

    protected static function modelClass(): string
    {
        return ClockingIn::class;
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
        ];
    }
}
