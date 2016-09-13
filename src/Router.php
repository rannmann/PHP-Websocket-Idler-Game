<?php
namespace Idler;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;

/**
 * Handles all connections, routing, etc.  Passes a ConnectionInterface
 * to the appropriate controllers.
 */
class Router implements MessageComponentInterface {
    protected $clients;
    // All channels we're listening on as keys, instanciated controllers for values.
    private $channels = []; // Anything here should also have a controller class by the same name.

    public function __construct() {}

    public function onOpen(Conn $conn) {
        global $clients;
        // Store the new connection to send messages to later
        $clients->attach($conn);
        // TODO: Authentication

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function addRoute($channel) {
        $channel = strtolower($channel);
        $channel = ucfirst($channel);
        require_once(__DIR__ . '/Controller/' . $channel . '.php');
        array_push($this->channels, $channel);
        $channelController = $this->_getControllerFromChannel($channel);
        $this->channels[$channel] = new $channelController();
        echo "Added route: " . $channel . "\n";
        return $this;
    }

    // Send message to appropriate class
    public function onMessage(Conn $from, $msg) {
        $matches = false;
        foreach($this->channels as $channel => $controller) {
            $pattern = '/^\/' . strtolower($channel) . ' /';
            if (preg_match($pattern, $msg, $matches)) {
                // Remove channel from message
                $msg = preg_replace($pattern, '', $msg, 1);
                $controller::onMessage($from, $msg);
                break;
            }
        }
    }

    public function onClose(Conn $conn) {
        global $clients;
        // The connection is closed, remove it, as we can no longer send it messages
        $clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(Conn $conn, \Exception $e) {
        global $clients;
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
        $clients->detach($conn);
    }

    private function _getControllerFromChannel($channel) {
        $className = trim($channel);
        $className = str_replace('/', '', $className);
        $className = ucfirst(strtolower($className));
        $className = '\\Idler\\Controller\\' . $className;
        return $className;
    }
}