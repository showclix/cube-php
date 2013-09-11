# Cube Client for PHP

Cube Client that supports communicating with a [Cube](https://github.com/square/cube) collector and evaluator.

# Usage

```php
    // Create a Client pointed at a local collector and evaluator
    $client = \Cube\Client::createHttpClient(array(
        'collector' => array(
            'host' => 'localhost',
            'port' => 1080,
        ),
        'evaluator' => array(
            'host' => 'localhost',
            'port' => 1081,
        ),
        'secure' => true,
    ));

    $res = $client->metricGet(array(
        'expression' => 'sum(cube_request)',
        'step' => \Cube\Client::INT_ONE_MINUTE,
        'limit' => 100,
    ));

    echo "There were {$res[0]['value']} hits during {$res[0]['time']}";
```

# Install

Via composer

    composer.phar install showclix/cube-php

# Todo

 - Implement \Cube\Connection\WebSocketConnection
 - Implement \Cube\Connection\UdpConnection
 - Add Travis CI Integaration complete with hooks to setup and install Cube/Mongo
