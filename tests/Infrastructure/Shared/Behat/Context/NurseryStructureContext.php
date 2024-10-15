<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use DateTimeImmutable;
use Exception;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;
use Ramsey\Uuid\Uuid;

final readonly class NurseryStructureContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is a nursery structure with uuid :uuid
     */
    public function createNurseryStructure(string $uuid): void
    {
        $this->storage->setNurseryStructure(NurseryStructureFactory::createOne([
            'uuid' => Uuid::fromString($uuid),
        ]));
    }

    /**
     * @Given that nursery structure has name :name
     */
    public function updateNurseryStructureName(string $name): void
    {
        $nurseryStructure = $this->storage->getNurseryStructure();
        $nurseryStructure->_set('name', $name);
        $nurseryStructure->_save();
    }

    /**
     * @Given that nursery structure has an address :address
     */
    public function updateNurseryStructureAddress(string $address): void
    {
        $nurseryStructure = $this->storage->getNurseryStructure();
        $nurseryStructure->_set('address', $address);
        $nurseryStructure->_save();
    }

    /**
     * @Given that nursery structure has a created date :date
     * @throws Exception
     */
    public function updateNurseryStructureCreatedAt(string $createdAt): void
    {
        $nurseryStructure = $this->storage->getNurseryStructure();
        $nurseryStructure->_set('createdAt', (new DateTimeImmutable($createdAt)));
        $nurseryStructure->_save();
    }

    /**
     * @Given that nursery structure has an updated date :date
     * @throws Exception
     */
    public function updateNurseryStructureUpdatedAt(string $updatedAt): void
    {
        $nurseryStructure = $this->storage->getNurseryStructure();
        $nurseryStructure->_set('updatedAt', (new DateTimeImmutable($updatedAt)));
        $nurseryStructure->_save();
    }
}
