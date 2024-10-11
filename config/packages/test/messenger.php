<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config): void {
    $messenger = $config->messenger();

    $messenger->transport('async')
        ->dsn('%env(MESSENGER_TRANSPORT_DSN)%')
        ->failureTransport('failed')
        ->options(['auto_setup' => true])
        ->retryStrategy()
        ->maxRetries(0)
    ;

    $messenger->transport('async_retry')
        ->dsn('%env(MESSENGER_TRANSPORT_DSN)%')
        ->failureTransport('failed')
        ->retryStrategy()
        ->maxRetries(3)
        ->delay(0)
    ;
};
