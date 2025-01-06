<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTimeImmutable;
use Exception;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\DosageFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\TreatmentFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

final readonly class TreatmentContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is a treatment with uuid :uuid
     */
    public function createTreatment(string $uuid): void
    {
        $this->storage->setTreatment(TreatmentFactory::createOne([
            'uuid' => Uuid::fromString($uuid),
        ]));
    }

    /**
     * @Given that treatment has name :name
     */
    public function updateTreatmentName(string $name): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('name', $name);
        $treatment->_save();
    }

    /**
     * @Given that treatment has description :description
     */
    public function updateTreatmentDescription(string $description): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('description', $description);
        $treatment->_save();
    }

    /**
     * @Given that treatment has a created date :date
     * @throws Exception
     */
    public function updateTreatmentCreatedAt(string $createdAt): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('createdAt', new DateTimeImmutable($createdAt));
        $treatment->_save();
    }

    /**
     * @Given that treatment has a start date :date
     * @throws Exception
     */
    public function updateTreatmentStartAt(string $startAt): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('startAt', new DateTimeImmutable($startAt));
        $treatment->_save();
    }

    /**
     * @Given that treatment has an end date :date
     * @throws Exception
     */
    public function updateTreatmentEndAt(string $endAt): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('endAt', new DateTimeImmutable($endAt));
        $treatment->_save();
    }

    /**
     * @Given that treatment is linked to child with uuid :uuid
     */
    public function updateTreatmentChild(string $uuid): void
    {
        $treatment = $this->storage->getTreatment();
        $treatment->_set('child', ChildFactory::find(['uuid' => $uuid])->_real());
        $treatment->_save();
    }

    /**
     * @Given that treatment has dosages:
     */
    public function addDosageTreatment(TableNode $table): void
    {
        $treatment = $this->storage->getTreatment();

        foreach ($table->getHash() as $row) {
            Assert::keyExists($row, 'dose', 'dose is required for each dosage.');
            Assert::keyExists($row, 'dosingTime', 'dosingTime is required for each dosage.');
            Assert::notEmpty($row['dose'], 'dose does not empty.');
            Assert::notEmpty($row['dosingTime'], 'dosingTime does not empty.');

            $dosingTime = DateTimeImmutable::createFromFormat('H:i', $row['dosingTime']);
            Assert::notFalse($dosingTime, 'The "dosingTime" format is invalid. Use "HH:MM".');

            $dosage = DosageFactory::createOne([
                'treatment' => $treatment,
                'dose' => $row['dose'],
                'dosingTime' => $dosingTime,
            ]);

            $treatment->addDosage($dosage->_real());
        }

        $treatment->_save();
    }

    /**
     * @Then the treatment should have :count dosages
     */
    public function theTreatmentShouldHaveDosages(int $count): void
    {
        $treatment = $this->storage->getTreatment();
        Assert::count($treatment->getDosages(), $count, sprintf('The treatment should have %d dosages.', $count));
    }
}
