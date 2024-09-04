<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CustomerLoginAction extends AbstractController
{
    public function __construct(private readonly JWTTokenManagerInterface $jwtManager)
    {
    }

    #[Route('/api/customers/login', name: 'api_customers_login', methods: ['POST'])]
    public function __invoke(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'Unauthorized'], 401);
        }

        return new JsonResponse([
            'user' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'token' => $this->jwtManager->create($user),
        ]);
    }
}
