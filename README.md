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

# API

## \Cube\Client

### [static] createHttpClient(array $conf)

param array $conf

Configuration array.  For example:

```php
array(
    'collector' => array(
        'host' => 'localhost',
        'port' => 1080,
    ),
    'evaluator' => array(
        'host' => 'localhost',
        'port' => 1081,
    ),
    'secure' => true,
)
```

return \Cube\Client

### eventPut(array $event)

param array $event

The event to push to cube.  Requires type, time and data options.

```php
array(
    'type' => 'example',
    'time' => time(),
    'data' => array(
        'key' => 'value',
    ),
)
```

returns array response from Cube

### eventGet(array $query)

param array $query

returns array

*EXAMPLE*

```php
$query = array(
    'expression' => 'request.eq(path, "search")',   // cube expression
    'limit' => 10,                                  // limit (optional)
);
$client->metricGet($query);
```

### metricGet(array $query)

param array $query Metric query to send to cube evaluator

returns array

*EXAMPLE*

```php
$query = array(
    'expression' => 'sum(type_name)',   // cube expression
    'start' => strtotime('-1 day'),     // start time (optional)
    'stop' => time(),                   // end time (optional)
    'limit' => 10,                      // limit (optional)
    'step' => Client::INT_ONE_MINUTE,   // time grouping interval
);
$res = $client->metricGet($query);
echo "There were {$res[0]['value']} during {$res[0]['time']}";
```

### typesGet()

returns array of all types currently in cube



# Todo

 - Implement \Cube\Connection\WebSocketConnection
 - Implement \Cube\Connection\UdpConnection
 - Add Travis CI Integaration complete with hooks to setup and install Cube/Mongo
