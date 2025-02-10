<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\Address;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Address>
 *
 * @codeCoverageIgnore
 */
final class AddressFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Address::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'address' => self::faker()->streetAddress(),
            'zipcode' => self::faker()->postcode(),
            'city' => self::faker()->city(),
        ];
    }
}
