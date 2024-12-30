<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;

class NurseryStructureFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        NurseryStructureFactory::createMany(5);
    }

    protected static function modelClass(): string
    {
        return NurseryStructure::class;
    }
}
