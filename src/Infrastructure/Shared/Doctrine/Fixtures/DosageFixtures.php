<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Infrastructure\Shared\Foundry\Factory\DosageFactory;

class DosageFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        DosageFactory::createMany(20);
    }

    protected static function modelClass(): string
    {
        return Dosage::class;
    }

    public function getDependencies(): array
    {
        return [
            TreatmentFixtures::class,
        ];
    }
}
