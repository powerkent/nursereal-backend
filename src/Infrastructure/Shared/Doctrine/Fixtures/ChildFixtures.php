<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;
use function Zenstruck\Foundry\faker;

class ChildFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nursery1 = NurseryStructureFactory::createOne();
        $nursery2 = NurseryStructureFactory::createOne();

        AgentFactory::createMany(4, ['nurseryStructures' => [$nursery1]]);
        AgentFactory::createMany(4, ['nurseryStructures' => [$nursery2]]);

        for ($i = 0; $i < 24; ++$i) {
            $nursery = $nursery1;
            if ($i > 12) {
                $nursery = $nursery2;
            }
            $customers = [];
            $customers[] = CustomerFactory::createOne();
            if (faker()->boolean()) {
                $customers[] = CustomerFactory::createOne();
            }

            ChildFactory::createOne(['nurseryStructure' => $nursery, 'customers' => $customers]);
        }

        $manager->flush();
    }
}
