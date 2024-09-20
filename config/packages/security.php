<?php

declare(strict_types=1);

use Nursery\Infrastructure\Shared\Security\JwtAuthenticator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\SecurityConfig;

return function (ContainerConfigurator $container, SecurityConfig $security) {
    $security->passwordHasher('Nursery\Domain\Shared\Model\Agent')
        ->algorithm('bcrypt');

    $security->passwordHasher('Nursery\Domain\Shared\Model\Customer')
        ->algorithm('bcrypt');

    $security->provider('agent_provider')
        ->entity()
        ->class('Nursery\Domain\Shared\Model\Agent')
        ->property('email');

    $security->provider('customer_provider')
        ->entity()
        ->class('Nursery\Domain\Shared\Model\Customer')
        ->property('email');

    $security->roleHierarchy('ROLE_MANAGER', ['ROLE_AGENT']);
    $security->roleHierarchy('ROLE_AGENT', ['ROLE_PARENT']);
    $security->roleHierarchy('ROLE_PARENT', []);

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

    $firewall = $security->firewall('api');
    $firewall->pattern('^/api')
        ->stateless(true)
        ->lazy(true)
        ->provider('agent_provider')
        ->customAuthenticators([JwtAuthenticator::class]);

    $firewall = $security->firewall('logout');
    $firewall->pattern('^/api/logout')
        ->stateless(true)
        ->logout()
        ->invalidateSession(true);

    $accessControl = $security->accessControl();
    $accessControl->path('^/api/docs')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/contexts')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/login/agent')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/login/customer')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $accessControl->path('^/api/logout')->roles(['IS_AUTHENTICATED_FULLY']);
};
