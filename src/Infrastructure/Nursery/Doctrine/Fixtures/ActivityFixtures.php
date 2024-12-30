<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures;

use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActivityFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;

/**
 * @codeCoverageIgnore
 */
class ActivityFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        ActivityFactory::createMany(6);
    }

    protected static function modelClass(): string
    {
        return Activity::class;
    }
}
