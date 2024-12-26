<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use DateInterval;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ContractDateFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\DosageFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\TreatmentFactory;
use function Zenstruck\Foundry\faker;

class ChildFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nursery1 = NurseryStructureFactory::createOne();
        $nursery2 = NurseryStructureFactory::createOne();

        AgentFactory::createMany(4, ['nurseryStructures' => [$nursery1]]);
        AgentFactory::createMany(4, ['nurseryStructures' => [$nursery2]]);

        for ($i = 0; $i < 24; ++$i) {
            $nursery = $nursery1;
            if ($i > 12) {
                $nursery = $nursery2;
            }
            $customers = [];
            $customers[] = CustomerFactory::createOne();
            if (faker()->boolean()) {
                $customers[] = CustomerFactory::createOne();
            }

            $contractDates = [];
            $timeStart = $this->getWeekDay();
            $timeStartHour = faker()->numberBetween(7, 11);
            $timeStartMinute = faker()->numberBetween(0, 59);
            $timeStart = $timeStart->setTime($timeStartHour, $timeStartMinute);
            $timeEnd = $this->getWeekDay();
            $timeEndHour = faker()->numberBetween(15, 19);
            $timeEndMinute = faker()->numberBetween(0, 59);
            $timeEnd = $timeEnd->setTime($timeEndHour, $timeEndMinute);
            $child = ChildFactory::createOne(['nurseryStructure' => $nursery, 'customers' => $customers])->_real();
            $treatment = TreatmentFactory::createOne()->_real();
            $treatment->setDosages([DosageFactory::createOne()->_real()]);
            $child->addTreatment($treatment);
            for ($j = 0; $j < 30; ++$j) {
                $contractDates[] = ContractDateFactory::createOne(['contractTimeStart' => $timeStart, 'contractTimeEnd' => $timeEnd, 'child' => $child])->_real();
                $timeStart = $timeStart->add(new DateInterval('P1D'));
                $timeEnd = $timeEnd->add(new DateInterval('P1D'));
                while ($this->isWeekend($timeStart)) {
                    $timeStart = $timeStart->add(new DateInterval('P1D'));
                    $timeEnd = $timeEnd->add(new DateInterval('P1D'));
                }
            }

            $child->setContractDates($contractDates);
            $manager->persist($child);
        }

        $manager->flush();
    }

    private function getWeekDay(): DateTime
    {
        $datetime = new DateTime();
        while ($this->isWeekend($datetime)) {
            $datetime = $datetime->add(new DateInterval('P1D'));
        }

        return $datetime;
    }

    private function isWeekend(DateTime $date): bool
    {
        /* @phpstan-ignore-next-line  */
        return (date('N', strtotime($date->format(DateTimeInterface::ATOM))) >= 6);
    }
}
