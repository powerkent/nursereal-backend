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
use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\PresenceFactory;
use Nursery\Infrastructure\Nursery\Foundry\Factory\Action\RestFactory;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AbstractFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\AgentFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ChildFixtures;
use Nursery\Infrastructure\Shared\Doctrine\Fixtures\ContractDateFixtures;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;

/**
 * @codeCoverageIgnore
 */
class RestFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(EntityManagerInterface $em, private QueryBusInterface $queryBus)
    {
        parent::__construct($em);
    }

    public function load(ObjectManager $manager): void
    {
        $presences = PresenceFactory::randomRange(20, 30);

        $now = (new DateTimeImmutable())->format('Y-m-d');
        foreach ($presences as $presence) {
            $presence = $presence->_real();
            $contractDates = $this->queryBus->ask((new FindContractDatesByChildQuery($presence->getChild())));
            foreach ($contractDates as $contractDate) {
                $rest = null;
                /** @var ContractDate $contractDate */
                if ($contractDate->getContractTimeStart()->format('Y-m-d') > $now) {
                    continue;
                }

                $agent = AgentFactory::random();
                $agent = $agent->_real();
                if ($contractDate->getContractTimeStart()->format('Y-m-d') < $now) {
                    $rest = RestFactory::createOne(['child' => $presence->getChild()]);
                    $rest = $rest->_real();
                    /* @var Rest $rest */
                    $rest->setQuality(RestQuality::cases()[array_rand(RestQuality::cases())]);
                    $rest->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $rest->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                    $rest->setCompletedAgent($agent);
                    $rest->setState(ActionState::ActionDone);
                }

                if ($contractDate->getContractTimeStart()->format('Y-m-d') === $now) {
                    $rest = RestFactory::createOne(['child' => $presence->getChild()]);
                    $rest = $rest->_real();
                    /* @var Rest $rest */
                    $rest->setStartDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT2H')));
                    $rest->setState(ActionState::ActionInProgress);
                    if ($contractDate->getContractTimeEnd() < (new DateTimeImmutable())) {
                        $rest->setQuality(RestQuality::cases()[array_rand(RestQuality::cases())]);
                        $rest->setEndDateTime(DateTimeImmutable::createFromInterface($contractDate->getContractTimeStart())->add(new DateInterval('PT3H')));
                        $rest->setCompletedAgent($agent);
                        $rest->setState(ActionState::ActionDone);
                    }
                }

                if (null !== $rest) {
                    $manager->persist($rest);
                }
            }
        }

        $manager->flush();
    }

    protected static function modelClass(): string
    {
        return Rest::class;
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
