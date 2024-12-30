<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\Foundry\Factory\TreatmentFactory;

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
        ];
    }
}
