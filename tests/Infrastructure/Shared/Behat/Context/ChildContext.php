<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use DateTimeImmutable;
use Exception;
use Nursery\Domain\Shared\Enum\Gender;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgeGroupFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\FamilyFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\IRPFactory;
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
        $child->_set('birthday', new DateTimeImmutable($birthday));
        $child->_save();
    }

    /**
     * @Given that child has a created date :date
     * @throws Exception
     */
    public function updateChildCreatedAt(string $createdAt): void
    {
        $child = $this->storage->getChild();
        $child->_set('createdAt', new DateTimeImmutable($createdAt));
        $child->_save();
    }

    /**
     * @Given that child has an updated date :date
     * @throws Exception
     */
    public function updateChildUpdatedAt(string $updatedAt): void
    {
        $child = $this->storage->getChild();
        $child->_set('updatedAt', new DateTimeImmutable($updatedAt));
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

    /**
     * @Given that child is linked to IPR with name :name
     * @Given that child has not IRP
     */
    public function updateChildIRP(?string $name = null): void
    {
        $child = $this->storage->getChild();
        $child->_set('irp', null !== $name ? IRPFactory::find(['name' => $name])->_real() : null);
        $child->_save();
    }

    /**
     * @Given that child is linked to family with uuid :uuid
     */
    public function updateChildFamily(string $uuid): void
    {
        $child = $this->storage->getChild();
        $child->_set('family', FamilyFactory::find(['uuid' => $uuid])->_real());
        $child->_save();
    }

    /**
     * @Given that child is walking :isWalking
     */
    public function updateChildIsWalking(string $isWalking): void
    {
        $child = $this->storage->getChild();
        $child->_set('isWalking', filter_var($isWalking, FILTER_VALIDATE_BOOLEAN));
        $child->_save();
    }

    /**
     * @Given that child has a gender :gender
     */
    public function updateChildGender(string $gender): void
    {
        $child = $this->storage->getChild();
        $child->_set('gender', Gender::from($gender));
        $child->_save();
    }

    /**
     * @Given that child is linked to AgeGroup with name :name
     * @Given that child has not AgeGroup
     */
    public function updateChildAgeGroup(?string $name = null): void
    {
        $child = $this->storage->getChild();
        $child->_set('ageGroup', null !== $name ? AgeGroupFactory::find(['name' => $name])->_real() : null);
        $child->_save();
    }
}
