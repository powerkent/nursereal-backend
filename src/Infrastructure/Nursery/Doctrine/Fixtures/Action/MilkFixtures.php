<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Fixtures\Action;

use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Application\Shared\Query\FindContractDatesByChildQuery;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action\Milk;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\MilkFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ContractDateFixtures;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;

/**
 * @codeCoverageIgnore
 */
class MilkFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(EntityManagerInterface $em, private QueryBusInterface $queryBus)
    {
        parent::__construct($em);
    }

    public function load(ObjectManager $manager): void
    {
        $presences = PresenceFactory::randomRange(20, 30);

        $now = new DateTimeImmutable()->format('Y-m-d');
        foreach ($presences as $presence) {
            $presence = $presence->_real();
            $contractDates = $this->queryBus->ask((new FindContractDatesByChildQuery($presence->getChild())));
            foreach ($contractDates as $contractDate) {
                $milk = null;
                /** @var ContractDate $contractDate */
                if ($contractDate->getContractTimeStart()->format('Y-m-d') > $now) {
                    continue;
                }

                $agent = AgentFactory::random();
                $agent = $agent->_real();
                if ($contractDate->getContractTimeStart()->format('Y-m-d') < $now) {
                    $milk = MilkFactory::createOne(['child' => $presence->getChild()]);
                    $milk = $milk->_real();
                    /* @var Milk $milk */
                    $milk->setQuantity(random_int(50, 250).' mL');
                    $milk->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $milk->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                    $milk->setCompletedAgent($agent);
                    $milk->setState(ActionState::ActionDone);
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') === $now) {
                    $milk = MilkFactory::createOne(['child' => $presence->getChild()]);
                    $milk = $milk->_real();
                    /* @var Milk $milk */
                    $milk->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $milk->setState(ActionState::ActionInProgress);
                    if ($contractDate->getContractTimeEnd() < (new DateTimeImmutable())) {
                        $milk->setQuantity(random_int(50, 250).' mL');
                        $milk->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                        $milk->setCompletedAgent($agent);
                        $milk->setState(ActionState::ActionDone);
                    }
                }

                if (null !== $milk) {
                    $manager->persist($milk);
                }
            }
        }

        $manager->flush();
    }

    protected static function modelClass(): string
    {
        return Milk::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
            PresenceFixtures::class,
            ContractDateFixtures::class,
            AgentFixtures::class,
        ];
    }
}
