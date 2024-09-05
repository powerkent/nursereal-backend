<?php

declare(strict_types=1);

use Nursery\Infrastructure\Shared\Security\JwtAuthenticator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\SecurityConfig;

return function (ContainerConfigurator $container, SecurityConfig $security) {
    // Configuration des password hashers
    $security->passwordHasher('Nursery\Domain\Shared\Model\Agent')
        ->algorithm('bcrypt');

    $security->passwordHasher('Nursery\Domain\Shared\Model\Customer')
        ->algorithm('bcrypt');

    // Providers pour Agent et Customer
    $security->provider('agent_provider')
        ->entity()
        ->class('Nursery\Domain\Shared\Model\Agent')
        ->property('email');

    $security->provider('customer_provider')
        ->entity()
        ->class('Nursery\Domain\Shared\Model\Customer')
        ->property('email');

    // Hiérarchie des rôles
    $security->roleHierarchy('ROLE_MANAGER', ['ROLE_AGENT']);
    $security->roleHierarchy('ROLE_AGENT', ['ROLE_PARENT']);
    $security->roleHierarchy('ROLE_PARENT', []);

    // Firewall pour la connexion des Agents
    $firewall = $security->firewall('login_agent');
    $firewall->pattern('^/api/login/agent')
        ->stateless(true)
        ->lazy(true)
        ->provider('agent_provider')
        ->jsonLogin()
        ->checkPath('/api/login/agent')
        ->usernamePath('email')
        ->passwordPath('password')
        ->successHandler('lexik_jwt_authentication.handler.authentication_success')
        ->failureHandler('lexik_jwt_authentication.handler.authentication_failure');

    // Firewall pour la connexion des Customers
    $firewall = $security->firewall('login_customer');
    $firewall->pattern('^/api/login/customer')
        ->stateless(true)
        ->lazy(true)
        ->provider('customer_provider')
        ->jsonLogin()
        ->checkPath('/api/login/customer')
        ->usernamePath('email')
        ->passwordPath('password')
        ->successHandler('lexik_jwt_authentication.handler.authentication_success')
        ->failureHandler('lexik_jwt_authentication.handler.authentication_failure');

    // Firewall pour les API avec JWT
    $firewall = $security->firewall('api');
    $firewall->pattern('^/api')
        ->stateless(true)
        ->lazy(true)
        ->provider('agent_provider')
        ->customAuthenticators([JwtAuthenticator::class]);

    // Firewall pour la déconnexion
    $firewall = $security->firewall('logout');
    $firewall->pattern('^/api/logout')
        ->stateless(true)
        ->logout()
        ->invalidateSession(true);

    // Autoriser les utilisateurs anonymes à accéder à la documentation API Platform
    $accessControl = $security->accessControl();
    // Autoriser l'accès anonyme à la documentation
    $accessControl->path('^/api/docs')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    // Autoriser l'accès anonyme aux contextes Hydra
    $accessControl->path('^/api/contexts')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    // Autoriser l'accès anonyme aux entrées du point d'entrée de l'API
    $accessControl->path('^/api')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/login/agent')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/login/customer')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/logout')->roles(['IS_AUTHENTICATED_FULLY']);
};
