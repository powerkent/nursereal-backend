<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat;

use Doctrine\ORM\EntityManagerInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Model\NurseryStructure;
use RuntimeException;
use Zenstruck\Foundry\Persistence\Proxy;
use function get_class;
use function sprintf;

final class Storage
{
    /**
     * @var array<class-string, Proxy<object>>
     */
    private array $storage = [];

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @template T of object
     *
     * @phpstan-param Proxy<T> $proxy
     */
    private function storeEntity(Proxy $proxy): void
    {
        $class = get_class($proxy->_real());

        $this->storage[$class] = $proxy;
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return Proxy<T>
     */
    private function findEntity(string $class): Proxy
    {
        if (null === $proxy = $this->storage[$class] ?? null) {
            throw new RuntimeException(sprintf('Cannot find %s in memory storage', $class));
        }

        $this->entityManager->clear();

        /* @phpstan-ignore-next-line */
        return $proxy;
    }

    /**
     * @return Proxy<NurseryStructure>
     */
    public function getNurseryStructure(): Proxy
    {
        return $this->findEntity(NurseryStructure::class);
    }

    /**
     * @param Proxy<NurseryStructure> $nurseryStructure
     */
    public function setNurseryStructure(Proxy $nurseryStructure): void
    {
        $this->storeEntity($nurseryStructure);
    }

    /**
     * @return Proxy<Child>
     */
    public function getChild(): Proxy
    {
        return $this->findEntity(Child::class);
    }

    /**
     * @param Proxy<Child> $child
     */
    public function setChild(Proxy $child): void
    {
        $this->storeEntity($child);
    }

    /**
     * @return Proxy<Customer>
     */
    public function getCustomer(): Proxy
    {
        return $this->findEntity(Customer::class);
    }

    /**
     * @param Proxy<Customer> $customer
     */
    public function setCustomer(Proxy $customer): void
    {
        $this->storeEntity($customer);
    }
}