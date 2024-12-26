<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Exception;
use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindConfigByUuidOrNameQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface|string|null $uuid = null,
        public ?string $name = null,
    ) {
        if (null === $this->uuid && null === $this->name) {
            throw new Exception('unable to find a config by uuid or name without uuid and name.');
        }
    }
}
