<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Application\Nursery\Query\FindActionByFiltersQuery;
use Nursery\Application\Shared\Query\FindContractDatesByChildQuery;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action\Presence;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ContractDateFixtures;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;

/**
 * @codeCoverageIgnore
 */
class PresenceFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(EntityManagerInterface $em, private QueryBusInterface $queryBus)
    {
        parent::__construct($em);
    }

    public function load(ObjectManager $manager): void
    {
        $children = ChildFactory::randomRange(60, 90);

        $now = new DateTimeImmutable()->format('Y-m-d');

        foreach ($children as $child) {
            $child = $child->_real();
            $contractDates = $this->queryBus->ask((new FindContractDatesByChildQuery($child)));
            foreach ($contractDates as $contractDate) {
                $presence = null;
                $agent = AgentFactory::random()->_real();
                if (mt_rand(1, 100) <= 20) {
                    $presence = PresenceFactory::createOne(['child' => $child, 'isAbsent' => true]);
                    $presence = $presence->_real();
                    $presence->setStartDateTime(null);
                    $presence->setEndDateTime(null);
                    $presence->setCompletedAgent($agent);
                    $presence->setState(ActionState::ActionDone);
                    $manager->persist($presence);
                    continue;
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') < $now) {
                    $presence = PresenceFactory::createOne(['child' => $child, 'isAbsent' => false]);
                    $presence = $presence->_real();
                    $presence->setStartDateTime($contractDate->getContractTimeStart());
                    $presence->setEndDateTime($contractDate->getContractTimeEnd());
                    $presence->setCompletedAgent($agent);
                    $presence->setState(ActionState::ActionDone);
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') === $now) {
                    $presence = PresenceFactory::createOne(['child' => $child, 'isAbsent' => false]);
                    $presence = $presence->_real();
                    $presence->setStartDateTime($contractDate->getContractTimeStart());
                    $presence->setState(ActionState::ActionInProgress);
                    if ($contractDate->getContractTimeEnd() < (new DateTimeImmutable())) {
                        $presence->setEndDateTime($contractDate->getContractTimeEnd());
                        $presence->setCompletedAgent($agent);
                        $presence->setState(ActionState::ActionDone);
                    }
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') > $now) {
                    $presence = PresenceFactory::createOne(['child' => $child, 'isAbsent' => false]);
                    $presence = $presence->_real();
                    $presence->setStartDateTime(null);
                    $presence->setEndDateTime(null);
                    $presence->setCompletedAgent(null);
                }

                if (null !== $presence) {
                    $manager->persist($presence);
                }
            }
        }

        $manager->flush();


        $presences = $this->queryBus->ask(new FindActionByFiltersQuery(['actions' => [ActionType::Presence->value], 'startDateTime' => new DateTimeImmutable('-2 days'), 'endDateTime' => new DateTimeImmutable('+2 days')]));
        foreach ($presences as $presence) {
            /** @var Presence $presence */
            if (null === $presence->getStartDateTime() && null === $presence->getEndDateTime() && !$presence->isAbsent()) {
                $manager->remove($presence);
                $manager->flush();
            }
        }
    }

    protected static function modelClass(): string
    {
        return Presence::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            ContractDateFixtures::class,
            AgentFixtures::class,
        ];
    }
}
