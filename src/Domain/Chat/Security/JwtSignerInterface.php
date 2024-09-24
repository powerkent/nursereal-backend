<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Security;

interface JwtSignerInterface
{
    public function getJwt(): string;
}
