<?php

ini_set('memory_limit', -1);
set_time_limit(0);// No Timeout

require_once __DIR__.'/../vendor/autoload.php';

$options = new \WabLab\ParallelServer\ParallelServerOptions();
$options->setConnectionsBacklog(-1);
$options->setBind('0.0.0.0');
$options->setPort(5555);
$options->setDebug(true);
//$options->setTimeout(10);

$server = new \WabLab\ParallelServer\ParallelServer($options);

$server->onConnectionEstablished(function($remoteAddress) use ($server) {
    $stream = $server->getStreamByAddress($remoteAddress);
    $stream->write("Welcome {$remoteAddress}".PHP_EOL);
    //$stream->close();
});

$server->onRead(function($remoteAddress) use ($server) {
    $stream = $server->getStreamByAddress($remoteAddress);
    $stream->write('Your message was: '.trim($stream->read()).PHP_EOL);
    //$stream->close();
});

$server->start();