<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;

class CustomerFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CustomerFactory::createMany(24);
    }

    protected static function modelClass(): string
    {
        return Customer::class;
    }

    public function getDependencies(): array
    {
        return [
            AgeGroupFixtures::class,
            FamilyFixtures::class,
        ];
    }
}
