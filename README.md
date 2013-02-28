# Cube Client for PHP

*This is really green.  There may be some major over hauls to this in the future.*

# Usage

```php
    // Create a Client that uses Http protocol to connect to localhost:1081
    $client = \Cube\Client::createHttpClient(array(
        'host' => 'localhost',
        'port' => 1081,
        'secure' => true,
    ));

    $res = $client->metricGet(array(
        'expression' => 'sum(cube_request)',
        'step' => \Cube\Client::INT_ONE_MINUTE,
        'limit' => 100,
    ));
```

# Install

Via composer

    composer.phar install ShowClix/cube-php

# Todo

 - Implement the \Cube\Connection\WebSocketConnection and \Cube\Connection\UdpConnection.
 - Implement collectd and eventPut for \HttpConnection
 - Add more test coverage
 - Make tests a bit less brittle when it comes to relying on Cube at a certain host/port with a certain data set