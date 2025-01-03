<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('zenstruck_foundry', [
        'auto_refresh_proxies' => true,
        'faker' => ['locale' => 'fr_FR'],
    ]);
};
