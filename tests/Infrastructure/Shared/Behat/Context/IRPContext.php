<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use DateTimeImmutable;
use Exception;
use Nursery\Infrastructure\Shared\Foundry\Factory\IRPFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;

final readonly class IRPContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is an IRP with name :name
     */
    public function createIRP(string $name): void
    {
        $this->storage->setIRP(IRPFactory::createOne([
            'name' => $name,
        ]));
    }

    /**
     * @Given that IRP has description :description
     */
    public function updateIRPDescription(string $description): void
    {
        $irp = $this->storage->getIRP();
        $irp->_set('description', $description);
        $irp->_save();
    }

    /**
     * @Given that IRP has a created date :date
     * @throws Exception
     */
    public function updateIRPCreatedAt(string $createdAt): void
    {
        $irp = $this->storage->getIRP();
        $irp->_set('createdAt', new DateTimeImmutable($createdAt));
        $irp->_save();
    }

    /**
     * @Given that IRP has a start date :date
     * @throws Exception
     */
    public function updateIRPStartAt(string $startAt): void
    {
        $irp = $this->storage->getIRP();
        $irp->_set('startAt', new DateTimeImmutable($startAt));
        $irp->_save();
    }

    /**
     * @Given that IRP has an end date :date
     * @throws Exception
     */
    public function updateIRPEndAt(string $endAt): void
    {
        $irp = $this->storage->getIRP();
        $irp->_set('endAt', new DateTimeImmutable($endAt));
        $irp->_save();
    }
}
