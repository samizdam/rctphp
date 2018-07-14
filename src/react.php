<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once 'Application.php';

$loop = React\EventLoop\Factory::create();

$app = new Application('reactPHP');

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($app) {
    return $app->execute();

});
$port = $argv[1];
$socket = new React\Socket\Server('0.0.0.0:'.$port, $loop);
$server->listen($socket);

echo "Server running at http://127.0.0.1:$port\n";

$loop->run();