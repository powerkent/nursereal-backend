<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\AgeGroup;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgeGroupFactory;

class AgeGroupFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        AgeGroupFactory::createMany(3);
    }

    protected static function modelClass(): string
    {
        return AgeGroup::class;
    }
}
