<?php
namespace Idler\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;
use Idler\Controller\AuthController;
use Idler\AppConfig;

/**
 * AppRouter
 *
 * Everything in our app runs through this class.  On new client connect,
 * new clients are attached to the global SplObjectStorage $clients container.
 * This class also handles disconnects/errors.  Messages are redirected to their
 * routers without the route name.
 * New classes should extend the DefaultController, not AppRouter.
 * Do not handle your own connections.
 */
class AppRouter implements MessageComponentInterface {
    private $_routes = []; // key = route, value = controller instance

    /**
     *  Add routes to our application, initializing new controllers for each route.
     *  @param array $routes The key is the route, and the value is the name (string) of a controller
     */
    public function __construct($routes) {
        $this->_routes = $routes;

        foreach($routes as $route => $controllerName) {
            $controllerName = "Idler\\Controller\\" . $controllerName;
            $this->_routes[$route] = new $controllerName();
        }
        echo "Initialized app router with " . count($routes) . " routes.\n";
    }

    public function onOpen(Conn $conn) {
        global $clients;
        // We can't try to authenticate until we're attached.  Maybe we should
        // force an authentication route before anything else?
        // Or require the first route param to always be authentication.
        $clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
        foreach($this->_routes as $routeController) {
            if (method_exists($routeController, 'onOpen')) {
                $routeController->onOpen($conn);
            }
        }
    }

    // Channels messages must start with a / and contain only alpha chars.
    public function onMessage(Conn $from, $msg) {
        if (preg_match('/^\/[a-zA-Z]+/', $msg, $matches)) {
            $route = $matches[0]; // Route name (ex: /chat)
            if (!empty($this->_routes[$route])) {
                // Remove route name from message
                $msg = preg_replace("/^\\$route /", '', $msg, 1);
                // Send message event to router
                return $this->_routes[$route]->onMessage($from, $msg);
            }
        }
        // No route found.
        echo "No route found for message: $msg\n";
        return;
    }

    public function onClose(Conn $conn) {
        global $clients;
        // Allow each router to disconnect gracefully first
        foreach($this->_routes as $routeController) {
            if (method_exists($routeController, 'onClose')) {
                $routeController->onClose($conn);
            }
        }
        echo "Client disconnected. ({$conn->resourceId})\n";
        $clients->detach($conn);
    }

    public function onError(Conn $conn, \Exception $e) {
        foreach($this->_routes as $routeController) {
            if (method_exists($routeController, 'onError')) {
                $routeController->onError($conn);
            }
        }
        $conn->close();
        echo $e->getMessage() . "\n";
    }
}