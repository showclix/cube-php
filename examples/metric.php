<?php

require_once(dirname(__DIR__) . '/vendor/autoload.php');

// Create a Client that uses Http protocol to connect to localhost:1081
$client = \Cube\Client::createHttpClient(array(
    'host' => 'localhost',
    'port' => 1081,
    'secure' => false,
));

$res = $client->metricGet(array(
    'expression' => 'sum(cube_request)',
    'step' => \Cube\Client::INT_ONE_MINUTE,
    'limit' => 100,
));

echo "There were {$res[0]['value']} hits during {$res[0]['time']}" . PHP_EOL;