<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\User;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserDomainInterface extends UserInterface
{
    public function getId(): ?int;
    public function getFirstname(): string;
    public function getLastname(): string;
}
