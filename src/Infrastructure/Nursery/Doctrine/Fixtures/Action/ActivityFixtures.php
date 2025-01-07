<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Application\Shared\Query\ContractDate\FindContractDatesByChildQuery;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action\Activity;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\Doctrine\Fixtures\ActionFixtures;
use Nursery\Infrastructure\Nursery\Doctrine\Fixtures\ActivityFixtures as WhatActivityFixtures;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\ActivityFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActivityFactory as WhatActivityFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ContractDateFixtures;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;

/**
 * @codeCoverageIgnore
 */
class ActivityFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(EntityManagerInterface $em, private readonly QueryBusInterface $queryBus)
    {
        parent::__construct($em);
    }

    public function load(ObjectManager $manager): void
    {
        $presences = PresenceFactory::randomRange(5, 10);

        $now = new DateTimeImmutable()->format('Y-m-d');
        foreach ($presences as $presence) {
            $presence = $presence->_real();
            $contractDates = $this->queryBus->ask(new FindContractDatesByChildQuery($presence->getChild()));
            foreach ($contractDates as $contractDate) {
                $activity = null;
                /** @var ContractDate $contractDate */
                $agent = AgentFactory::random();
                $agent = $agent->_real();
                if ($contractDate->getContractTimeStart()->format('Y-m-d') < $now) {
                    $activity = ActivityFactory::createOne(['child' => $presence->getChild()]);
                    $activity = $activity->_real();
                    /* @var Activity $activity */
                    $activity->setActivity(WhatActivityFactory::random()->_real());
                    $activity->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $activity->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                    $activity->setCompletedAgent($agent);
                    $activity->setState(ActionState::ActionDone);
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') === $now) {
                    $activity = ActivityFactory::createOne(['child' => $presence->getChild()]);
                    $activity = $activity->_real();
                    /* @var Activity $activity */
                    $activity->setActivity(WhatActivityFactory::random()->_real());
                    $activity->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $activity->setState(ActionState::ActionInProgress);
                    if ($contractDate->getContractTimeEnd() < (new DateTimeImmutable())) {
                        $activity->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                        $activity->setCompletedAgent($agent);
                        $activity->setState(ActionState::ActionDone);
                    }
                }

                if (null !== $activity) {
                    $manager->persist($activity);
                }
            }
        }


        $manager->flush();
    }

    protected static function modelClass(): string
    {
        return Activity::class;
    }
    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            ContractDateFixtures::class,
            PresenceFixtures::class,
            ActionFixtures::class,
            AgentFixtures::class,
            WhatActivityFixtures::class,
        ];
    }
}
