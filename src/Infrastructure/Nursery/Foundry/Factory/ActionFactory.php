<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory;

use DateInterval;
use DateTimeImmutable;
use Faker\Generator;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Infrastructure\Shared\Foundry\Factory\AgentFactory;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Action>
 *
 * @codeCoverageIgnore
 */
class ActionFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Action::class;
    }

    /**
     * @return array<string, mixed>
     */
    public function defaults(): array
    {
        /** @var Generator $uniqueGenerator */
        $uniqueGenerator = self::faker()->unique();

        $date = DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 days'));
        $date->setTime(self::faker()->numberBetween(7, 12), self::faker()->numberBetween(0, 59));

        return [
            'uuid' => Uuid::fromString($uniqueGenerator->uuid()),
            'state' => self::faker()->randomElement(ActionState::cases()),
            'createdAt' => $date,
            'updatedAt' => self::faker()->boolean() ? $date->add(new DateInterval('PT1H')) : null,
            'child' => ChildFactory::random(),
            'agent' => AgentFactory::randomOrCreate(),
            'comment' => self::faker()->boolean() ? self::faker()->text() : null,
        ];
    }
}
