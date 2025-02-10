<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\FamilyFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;
use Ramsey\Uuid\Uuid;

final readonly class FamilyContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is a family with uuid :uuid
     */
    public function createFamily(string $uuid): void
    {
        $this->storage->setFamily(FamilyFactory::createOne([
            'uuid' => Uuid::fromString($uuid),
        ]));
    }

    /**
     * @Given that family has name :name
     */
    public function updateFamilyName(string $name): void
    {
        $family = $this->storage->getFamily();
        $family->_set('name', $name);
        $family->_save();
    }

    /**
     * @Given that family is linked to customer A with uuid :uuid
     */
    public function updateFamilyCustomerA(string $uuid): void
    {
        $family = $this->storage->getFamily();
        $family->_set('customerA', CustomerFactory::find(['uuid' => Uuid::fromString($uuid)]));
        $family->_save();
    }

    /**
     * @Given that family is linked to customer B with uuid :uuid
     */
    public function updateFamilyCustomerB(string $uuid): void
    {
        $family = $this->storage->getFamily();
        $family->_set('customerB', CustomerFactory::find(['uuid' => Uuid::fromString($uuid)]));
        $family->_save();
    }
}
