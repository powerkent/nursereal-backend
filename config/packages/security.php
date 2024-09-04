<?php

use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $securityConfig): void {
    $securityConfig->passwordHasher('Nursery\Domain\Shared\Model\Agent')
        ->algorithm('auto');
    $securityConfig->passwordHasher('Nursery\Domain\Shared\Model\Customer')
        ->algorithm('auto');

    // Providers
    $provider = $securityConfig->provider('app_user_provider');
    $provider->entity()
        ->class('Nursery\Domain\Shared\Model\Agent')
        ->property('email');

    $securityConfig->roleHierarchy('ROLE_MANAGER', ['ROLE_AGENT']);
    $securityConfig->roleHierarchy('ROLE_AGENT', ['ROLE_PARENT']);

    // Firewalls
    $devFirewall = $securityConfig->firewall('dev');
    $devFirewall->pattern('^/(_(profiler|wdt)|css|images|js)/')
        ->security(false);

    $publicFirewall = $securityConfig->firewall('public');
    $publicFirewall
        ->pattern('^/api/(docs|contexts)')
        ->security(false);

    $apiFirewall = $securityConfig->firewall('api');
    $apiFirewall
        ->pattern('^/api/')
        ->stateless(true)
        ->provider('app_user_provider')
        ->jsonLogin()
        ->checkPath('/api/login')   // Vérification que cette route est correctement configurée pour le login
        ->usernamePath('email')
        ->passwordPath('password');
    
    $mainFirewall = $securityConfig->firewall('main');
    $mainFirewall
        ->lazy(true)
        ->provider('app_user_provider')
        ->logout()
        ->path('/api/logout');

    $securityConfig->accessControl()
        ->path('^/api/login')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $securityConfig->accessControl()
        ->path('^/api/docs')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $securityConfig->accessControl()
        ->path('^/api/contexts')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
    $securityConfig->accessControl()
        ->path('^/api')->roles(['IS_AUTHENTICATED_ANONYMOUSLY']);
};