<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Exception;
use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgentByUuidOrIdQuery implements QueryInterface
{
    /**
     * @throws Exception
     */
    public function __construct(
        public UuidInterface|string|null $uuid = null,
        public ?int $id = null,
    ) {
        if (null === $this->uuid && null === $this->id) {
            throw new Exception('unable to find agent by uuid or id without uuid and id.');
        }
    }
}
