<?php
namespace Idler\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;

class Chat implements MessageComponentInterface {
    protected $clients;
    private $channel = 'chat';

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(Conn $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(Conn $from, $msg) {
        // Todo: Move to a router
        if (!preg_match('/^\/chat /', $msg)) {
            return;
        }
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            //if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
            $client->send($this->_formatMessage($from, $msg));
            //}
        }
    }

    public function onClose(Conn $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(Conn $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
        $this->clients->detach($conn);
    }

    private function _formatMessage(Conn $from, $msg) {
        return "<" . $from->resourceId . "> $msg";
    }
}