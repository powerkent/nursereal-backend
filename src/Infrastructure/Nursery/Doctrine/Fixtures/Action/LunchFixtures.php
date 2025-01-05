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
use Nursery\Domain\Nursery\Enum\LunchQuality;
use Nursery\Domain\Nursery\Model\Action\Lunch;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\LunchFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ContractDateFixtures;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;

/**
 * @codeCoverageIgnore
 */
class LunchFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(EntityManagerInterface $em, private readonly QueryBusInterface $queryBus)
    {
        parent::__construct($em);
    }

    public function load(ObjectManager $manager): void
    {
        $presences = PresenceFactory::randomRange(20, 30);

        $now = new DateTimeImmutable()->format('Y-m-d');
        foreach ($presences as $presence) {
            $presence = $presence->_real();
            $contractDates = $this->queryBus->ask(new FindContractDatesByChildQuery($presence->getChild()));
            foreach ($contractDates as $contractDate) {
                $lunch = null;
                /** @var ContractDate $contractDate */
                if ($contractDate->getContractTimeStart()->format('Y-m-d') > $now) {
                    continue;
                }

                $agent = AgentFactory::random();
                $agent = $agent->_real();
                if ($contractDate->getContractTimeStart()->format('Y-m-d') < $now) {
                    $lunch = LunchFactory::createOne(['child' => $presence->getChild()]);
                    $lunch = $lunch->_real();
                    /* @var Lunch $lunch */
                    $lunch->setQuality(LunchQuality::cases()[array_rand(LunchQuality::cases())]);
                    $lunch->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $lunch->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                    $lunch->setCompletedAgent($agent);
                    $lunch->setState(ActionState::ActionDone);
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') === $now) {
                    $lunch = LunchFactory::createOne(['child' => $presence->getChild()]);
                    $lunch = $lunch->_real();
                    /* @var Lunch $lunch */
                    $lunch->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $lunch->setState(ActionState::ActionInProgress);
                    if ($contractDate->getContractTimeEnd() < (new DateTimeImmutable())) {
                        $lunch->setQuality(LunchQuality::cases()[array_rand(LunchQuality::cases())]);
                        $lunch->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                        $lunch->setCompletedAgent($agent);
                        $lunch->setState(ActionState::ActionDone);
                    }
                }

                if (null !== $lunch) {
                    $manager->persist($lunch);
                }
            }
        }


        $manager->flush();
    }

    protected static function modelClass(): string
    {
        return Lunch::class;
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
