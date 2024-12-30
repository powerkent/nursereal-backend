<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Nursery\Model\Action\Treatment;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\TreatmentFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\TreatmentFixtures as WhatTreatmentFixtures;

/**
 * @codeCoverageIgnore
 */
class TreatmentFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TreatmentFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return Treatment::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            AgentFixtures::class,
            WhatTreatmentFixtures::class,
        ];
    }
}
