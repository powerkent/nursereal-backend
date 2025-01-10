<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Infrastructure\Shared\Foundry\Factory\ShiftTypeFactory;

class ShiftTypeFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ShiftTypeFactory::createMany(3);
    }

    protected static function modelClass(): string
    {
        return ShiftType::class;
    }

    public function getDependencies(): array
    {
        return [
            NurseryStructureFixtures::class,
        ];
    }
}
