<?php

require_once(dirname(__DIR__) . '/vendor/autoload.php');

// Create a Client that uses Http protocol to connect to localhost:1081
$client = \Cube\Client::createHttpClient(array(
    'secure' => true,
    'collector' => array(
        'host' => 'localhost',
        'port' => 1080,
    ),
    'evaluator' => array(
        'host' => 'localhost',
        'port' => 1081,
    )
));

$res = $client->eventPut(array(
    'type' => 'example',
    'time' => time(),
    'data' => array(
        'key1' => 'value1',
    ),
));

echo "There were {$res[0]['value']} hits during {$res[0]['time']}" . PHP_EOL;
