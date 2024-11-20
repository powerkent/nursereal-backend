<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActivityFactory;

class ActivityFixtures extends Fixture
{
    private const array ACTIVITIES = [
        'Comptines',
        'Instruments de musique',
        'Tapis d’éveil',
        'Pâte à modeler',
        'Transvasement',
        'Peinture',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::ACTIVITIES as $activity) {
            ActivityFactory::createOne(['name' => $activity]);
        }

        $manager->flush();
    }
}
