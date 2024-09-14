<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry;

use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Child;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Child>
 */
final class ChildFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Child::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid' => Uuid::uuid4(),
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'birthday' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'nurseryStructure' => NurseryStructureFactory::random(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'irp' => self::faker()->boolean() ? IRPFactory::new() : null,
            'treatments' => [],
            'customers' => [CustomerFactory::random()],
            'contractDates' => [],
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Child $child) {
            $customers = CustomerFactory::new()->createMany(2);
            foreach ($customers as $customer) {
                $child->addCustomer($customer);
            }
        });
    }
}
