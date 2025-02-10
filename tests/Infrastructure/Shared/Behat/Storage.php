<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat;

use Doctrine\ORM\EntityManagerInterface;
use Nursery\Domain\Shared\Model\Address;
use Nursery\Domain\Shared\Model\AgeGroup;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Model\IRP;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\Treatment;
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

    public function __construct(private readonly EntityManagerInterface $entityManager)
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

    /**
     * @return Proxy<IRP>
     */
    public function getIRP(): Proxy
    {
        return $this->findEntity(IRP::class);
    }

    /**
     * @param Proxy<IRP> $irp
     */
    public function setIRP(Proxy $irp): void
    {
        $this->storeEntity($irp);
    }

    /**
     * @return Proxy<Treatment>
     */
    public function getTreatment(): Proxy
    {
        return $this->findEntity(Treatment::class);
    }

    /**
     * @param Proxy<Treatment> $treatment
     */
    public function setTreatment(Proxy $treatment): void
    {
        $this->storeEntity($treatment);
    }

    /**
     * @return Proxy<Dosage>
     */
    public function getDosage(): Proxy
    {
        return $this->findEntity(Dosage::class);
    }

    /**
     * @param Proxy<Dosage> $dosage
     */
    public function setDosage(Proxy $dosage): void
    {
        $this->storeEntity($dosage);
    }

    /**
     * @return Proxy<AgeGroup>
     */
    public function getAgeGroup(): Proxy
    {
        return $this->findEntity(AgeGroup::class);
    }

    /**
     * @param Proxy<AgeGroup> $ageGroup
     */
    public function setAgeGroup(Proxy $ageGroup): void
    {
        $this->storeEntity($ageGroup);
    }

    /**
     * @return Proxy<Address>
     */
    public function getAddress(): Proxy
    {
        return $this->findEntity(Address::class);
    }

    /**
     * @param Proxy<Address> $address
     */
    public function setAddress(Proxy $address): void
    {
        $this->storeEntity($address);
    }

    /**
     * @return Proxy<Avatar>
     */
    public function getAvatar(): Proxy
    {
        return $this->findEntity(Avatar::class);
    }

    /**
     * @param Proxy<Avatar> $avatar
     */
    public function setAvatar(Proxy $avatar): void
    {
        $this->storeEntity($avatar);
    }

    /**
     * @return Proxy<Family>
     */
    public function getFamily(): Proxy
    {
        return $this->findEntity(Family::class);
    }

    /**
     * @param Proxy<Family> $family
     */
    public function setFamily(Proxy $family): void
    {
        $this->storeEntity($family);
    }
}
