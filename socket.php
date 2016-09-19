<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ .'/vendor/autoload.php';
use Idler\AppConfig;
use Idler\Controller\AppRouter;

// Connected clients in global var.
$clients = new \SplObjectStorage;

$appRouter = new AppRouter([
    '/auth' => 'AuthController',
    '/chat' => 'ChatController'
]);

$app = new Ratchet\App(
    AppConfig::$domain,
    AppConfig::$port,
    '0.0.0.0'
);
// We want to share auth sessions across all requests, so we're not going to use
// Ratchet's routes for anything.  Instead, we're pointing everything to
// our own router.  This makes adding a new controller super simple too.
$app->route('/', $appRouter, array('*'));

echo "Starting socket server on " . AppConfig::$domain . ':' . AppConfig::$port . "\n";
$app->run();