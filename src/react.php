<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once 'Application.php';

$loop = React\EventLoop\Factory::create();

$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) {

    $app = new Application('reactPHP');
    $app->execute();
    return new React\Http\Response(
        200,
        array('Content-Type' => 'text/plain'),
        "Hello World!\n"
    );
});
$port = $argv[1];
$socket = new React\Socket\Server($port, $loop);
$server->listen($socket);

echo "Server running at http://127.0.0.1:$port\n";

$loop->run();