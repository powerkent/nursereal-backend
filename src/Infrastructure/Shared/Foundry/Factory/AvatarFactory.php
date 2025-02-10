<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Faker\Factory;
use Nursery\Domain\Shared\Enum\AvatarType;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Avatar>
 *
 * @codeCoverageIgnore
 */
final class AvatarFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Avatar::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        return [
            'type' => $faker->randomElement(AvatarType::cases()),
            'contentUrl' => $faker->imageUrl(),
        ];
    }
}
