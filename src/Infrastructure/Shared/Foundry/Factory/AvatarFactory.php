<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Faker\Factory;
use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Avatar>
 */
final class AvatarFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Avatar::class;
    }

    protected function defaults(): array|callable
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        return [
            'uuid' => Uuid::uuid4(),
            'contentUrl' => $faker->imageUrl(),
        ];
    }
}
