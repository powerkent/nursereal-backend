<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Infrastructure\Shared\Foundry\Factory\AvatarFactory;

class AvatarFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        AvatarFactory::createMany(10);
    }

    protected static function modelClass(): string
    {
        return Avatar::class;
    }
}
