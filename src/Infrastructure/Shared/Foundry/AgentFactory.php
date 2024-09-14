<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry;

use Nursery\Domain\Shared\Model\Agent;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Agent>
 */
final class AgentFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Agent::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'uuid'      => Uuid::uuid4(),
            'firstname' => self::faker()->firstName(),
            'lastname'  => self::faker()->lastName(),
            'email'     => self::faker()->email(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'updatedAt' => self::faker()->boolean() ? \DateTimeImmutable::createFromMutable(self::faker()->dateTime()) : null,
            'password'  => self::faker()->password(),
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Agent $agent) {
            $nurseryStructures = NurseryStructureFactory::randomRange(1, 2);
            foreach ($nurseryStructures as $nurseryStructure) {
                $nurseryStructure->addAgent($agent);
            }
        });
    }
}
