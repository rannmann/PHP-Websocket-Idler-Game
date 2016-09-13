<?php
use Idler\AppConfig;
use Idler\Router;
use Ratchet\Http\HttpServer;
use Ratchet\Http\OriginCheck;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

$router = new Router();
$router->addRoute('chat');

//$checkedApp = new OriginCheck(new WsServer($router), array('localhost'));
//$checkedApp->allowedOrigins[] = AppConfig::$domain;


$server = IoServer::factory(
    new HttpServer(
        new WsServer($router)
    ),
    AppConfig::$port
);

// Connected clients in global var.
$clients = new \SplObjectStorage;

$server->run();