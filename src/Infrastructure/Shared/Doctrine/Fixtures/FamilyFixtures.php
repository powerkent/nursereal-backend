<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Infrastructure\Shared\Foundry\Factory\FamilyFactory;

class FamilyFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        FamilyFactory::createMany(20);
    }

    protected static function modelClass(): string
    {
        return Family::class;
    }
}
