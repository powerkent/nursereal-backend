<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateMalformedStringException;
use DateTimeImmutable;
use Nursery\Domain\Shared\Model\Family;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Family>
 *
 * @codeCoverageIgnore
 */
final class FamilyFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Family::class;
    }

    /**
     * @return array<string, mixed>
     * @throws DateMalformedStringException
     */
    protected function defaults(): array
    {
        $createdAt = DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-60 days'));
        $updatedAt = null;
        if (self::faker()->boolean()) {
            $now = new DateTimeImmutable('now');
            $intervalDays = $now->diff($createdAt)->days;
            $number = self::faker()->numberBetween(0, $intervalDays);
            $updatedAt = (clone $createdAt)->modify("+$number days");
        }

        return [
            'uuid' => Uuid::uuid4(),
            'name' => self::faker()->name(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-60 days')),
            'updatedAt' => $updatedAt,
            'internalComment' => self::faker()->boolean() ? self::faker()->text() : null,
            'customerA' => null,
            'customerB' => null,
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Family $family): void {
            $customers = CustomerFactory::createRange(1, 2, ['family' => $family]);
            $family->setCustomerA($customers[0]->_real());

            if (isset($customers[1])) {
                $customerB = $customers[1]->_real();
                if (self::faker()->boolean()) {
                    $customerB->setAddress($family->getCustomerA()?->getAddress());
                }
                $family->setCustomerB($customers[1]->_real());
            }
        });
    }
}
