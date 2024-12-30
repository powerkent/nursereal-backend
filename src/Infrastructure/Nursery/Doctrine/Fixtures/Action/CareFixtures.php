<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Nursery\Model\Action\Care;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\CareFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;

/**
 * @codeCoverageIgnore
 */
class CareFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CareFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return Care::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            AgentFixtures::class,
        ];
    }
}
