<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Foundry\Factory\Action;

use Nursery\Domain\Nursery\Enum\RestQuality;
use Nursery\Domain\Nursery\Model\Action\Rest;
use Nursery\Infrastructure\Nursery\Foundry\Factory\ActionFactory;

/**
 * @codeCoverageIgnore
 */
final class RestFactory extends ActionFactory
{
    protected function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'quality' => self::faker()->randomElement(RestQuality::cases()),
        ]);
    }

    public static function class(): string
    {
        return Rest::class;
    }
}
