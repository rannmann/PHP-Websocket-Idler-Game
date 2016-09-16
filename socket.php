<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require __DIR__ .'/vendor/autoload.php';
use Idler\AppConfig;
use Idler\Controller\AuthController;
use Idler\Controller\ChatController;


// Connected clients in global var.
$clients = new \SplObjectStorage;

$chat = new ChatController;
//$auth = new AuthController;
//$appRouter = new Router([
 //   '/chat' => 'ChatController'
//]);

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App(
    AppConfig::$domain,
    AppConfig::$port,
    '0.0.0.0'
);
// We want to share auth sessions across routes, so we're not going to use
// Ratchet's routes for anything.  Instead, we're pointing everything to
// our own router.
$app->route('/chat', $chat, array('*'));

echo "Starting socket server on " . AppConfig::$domain . ':' . AppConfig::$port . "\n";
$app->run();