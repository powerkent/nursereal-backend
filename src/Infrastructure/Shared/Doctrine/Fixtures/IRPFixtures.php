<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\IRP;
use Nursery\Infrastructure\Shared\Foundry\Factory\IRPFactory;

class IRPFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        IRPFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return IRP::class;
    }
}
