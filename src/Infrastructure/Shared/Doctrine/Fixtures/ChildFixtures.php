<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;

class ChildFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $children = ChildFactory::createMany(100);

        foreach ($children as $child) {
            $child = $child->_real();
            $randomNumber = rand(0, 2);
            for ($i = 0; $i < $randomNumber; ++$i) {
                $customer = CustomerFactory::random()->_real();
                $child->addCustomer($customer);
            }

            if (isset($customer)) {
                $customer->addChild($child);
                $customer = null;
            }
        }

        $manager->flush();
    }

    protected static function modelClass(): string
    {
        return Child::class;
    }

    public function getDependencies(): array
    {
        return [
            NurseryStructureFixtures::class,
            IRPFixtures::class,
            CustomerFixtures::class,
        ];
    }
}
