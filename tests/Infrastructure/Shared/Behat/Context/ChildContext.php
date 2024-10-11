<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;
use Ramsey\Uuid\Uuid;


final readonly class ChildContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is a child with uuid :uuid
     */
    public function createChild(string $uuid): void
    {
        $this->storage->setChild(ChildFactory::createOne([
            'uuid' => Uuid::fromString($uuid),
        ]));
    }

    /**
     * @Given that child has firstname :firstname
     */
    public function updateChildFirstname(string $firstname): void
    {
        $child = $this->storage->getChild();
        $child->_set('firstname', $firstname);
        $child->_save();
    }

    /**
     * @Given that child has lastname :lastname
     */
    public function updateChildLastname(string $lastname): void
    {
        $child = $this->storage->getChild();
        $child->_set('lastname', $lastname);
        $child->_save();
    }

    /**
     * @Given that child has a birthday on :birthday
     * @throws Exception
     */
    public function updateChildBirthday(string $birthday): void
    {
        $child = $this->storage->getChild();
        $child->_set('birthday', (new DateTimeImmutable($birthday)));
        $child->_save();
    }

    /**
     * @Given that child has a created date :date
     * @throws Exception
     */
    public function updateChildCreatedAt(string $createdAt): void
    {
        $child = $this->storage->getChild();
        $child->_set('createdAt', (new DateTimeImmutable($createdAt)));
        $child->_save();
    }

    /**
     * @Given that child has an updated date :date
     * @throws Exception
     */
    public function updateChildUpdatedAt(string $updatedAt): void
    {
        $child = $this->storage->getChild();
        $child->_set('updatedAt', (new DateTimeImmutable($updatedAt)));
        $child->_save();
    }

    /**
     * @Given that child is linked to nursery structure with uuid :uuid
     */
    public function updateChildNurseryStructure(string $uuid): void
    {
        $child = $this->storage->getChild();
        $child->_set('nurseryStructure', NurseryStructureFactory::find(['uuid' => $uuid])->_real());
        $child->_save();
    }
}