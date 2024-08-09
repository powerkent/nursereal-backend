<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Command;

use DateTimeInterface;

class MaClasse
{
    public function __construct(
        public int $id,
        public string $comment,
        public DateTimeInterface $date,
    ) {
    }
}
