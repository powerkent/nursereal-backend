<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @template TModel of object
 * @template-extends PersistentProxyObjectFactory<TModel>
 */
abstract class AbstractModelFactory extends PersistentProxyObjectFactory
{
    /**
     * @param array<string, string|int> $attributes
     *
     * @return list<TModel>
     */
    public static function randomOrCreateMany(int $number, array $attributes = []): array
    {
        $requiredPersistedModels = self::count();
        // If we already have enough persisted models, use randomSet()
        if ($requiredPersistedModels >= $number) {
            return array_map(fn ($proxy) => $proxy->object(), self::randomSet($number));
        }

        // Otherwise, fetch the models we already have if it's more than 0
        if ($requiredPersistedModels > 0) {
            $result = array_map(fn ($proxy) => $proxy->object(), self::randomSet($requiredPersistedModels));
        } else {
            // Otherwise start from scratch.
            $result = [];
        }

        // Create the remaining models ( or all, if $requiredPersistedModels is 0 ).
        for (; ($requiredPersistedModels - $number) < 0; --$number) {
            $result[] = self::createOne($attributes)->object();
        }

        return $result;
    }
}
