<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Infrastructure\Nursery\Doctrine\Fixtures\ActivityFixtures as WhatActivityFixtures;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\ActivityFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;

/**
 * @codeCoverageIgnore
 */
class ActivityFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ActivityFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return Activity::class;
    }
    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            AgentFixtures::class,
            WhatActivityFixtures::class,
        ];
    }
}
