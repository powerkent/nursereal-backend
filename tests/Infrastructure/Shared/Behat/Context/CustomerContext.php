<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use CurationDispatcher\Infrastructure\CurationDispatcher\Foundry\Factory\ProductFactory;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\CustomerFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\NurseryStructureFactory;
use Nursery\Tests\Infrastructure\Shared\Behat\Storage;
use Ramsey\Uuid\Uuid;


final readonly class CustomerContext implements Context
{
    public function __construct(
        private Storage $storage,
    ) {
    }

    /**
     * @Given there is a customer with uuid :uuid
     */
    public function createCustomer(string $uuid): void
    {
        $this->storage->setCustomer(CustomerFactory::createOne([
            'uuid' => Uuid::fromString($uuid),
        ]));
    }

    /**
     * @Given that customer has firstname :firstname
     */
    public function updateCustomerFirstname(string $firstname): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('firstname', $firstname);
        $customer->_save();
    }

    /**
     * @Given that customer has lastname :lastname
     */
    public function updateCustomerLastname(string $lastname): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('lastname', $lastname);
        $customer->_save();
    }

    /**
     * @Given that customer has an email :email
     */
    public function updateCustomerEmail(string $email): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('email', $email);
        $customer->_save();
    }

    /**
     * @Given that customer has a phone number :phoneNumber
     */
    public function updateCustomerPhoneNumber(string $phoneNumber): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('phoneNumber', $phoneNumber);
        $customer->_save();
    }

    /**
     * @Given that customer has a password :password
     */
    public function updateCustomerPassword(string $password): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('password', $password);
        $customer->_save();
    }

    /**
     * @Given that customer has a created date :date
     * @throws Exception
     */
    public function updateCustomerCreatedAt(string $createdAt): void
    {
        $customer = $this->storage->getCustomer();
        $customer->_set('createdAt', (new DateTimeImmutable($createdAt)));
        $customer->_save();
    }
}