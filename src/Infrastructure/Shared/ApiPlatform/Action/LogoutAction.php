<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LogoutAction extends AbstractController
{
    public function __invoke(
        TokenStorageInterface $tokenStorage,
        Security $security,
    ): Response {
        if(null === $security->getUser()) {
            return new Response(null, 204);
        }

        $tokenStorage->setToken(null);

        return new Response(null, 204);
    }
}
