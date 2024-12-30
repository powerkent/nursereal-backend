<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;

/**
 * @codeCoverageIgnore
 */
class PresenceFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        PresenceFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return Presence::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            AgentFixtures::class,
        ];
    }
}
