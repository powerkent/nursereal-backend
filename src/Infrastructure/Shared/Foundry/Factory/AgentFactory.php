<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;

/**
 * @extends AbstractModelFactory<Agent>
 *
 * @codeCoverageIgnore
 */
final class AgentFactory extends AbstractModelFactory
{
    public static function class(): string
    {
        return Agent::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'avatar' => AvatarFactory::createOne(['contentUrl' => $faker->imageUrl($firstname, $lastname)]),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => self::faker()->email(),
            'user' => self::faker()->name(),
            'password' => self::faker()->password(),
            'roles' => [Roles::Agent->value],
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')) : null,
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Agent $agent) {
            $nurseryStructures = NurseryStructureFactory::randomRange(1, 1);
            foreach ($nurseryStructures as $nurseryStructure) {
                $nurseryStructure->addAgent($agent);
            }
        });
    }
}
