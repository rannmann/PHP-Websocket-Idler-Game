<?php
namespace Idler\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;
use Idler\Controller\AuthController;
use Idler\AppConfig;

class ChatController implements MessageComponentInterface {
    private $logs;

    public function __construct() {
        $this->logs = [];
        echo "Created new ChatController\n";
    }

    public function onOpen(Conn $conn) {
        global $clients;
        if (AuthController::isValid($conn)) {
            $clients->attach($conn);
            echo "New connection! ({$conn->resourceId})\n";
            $conn->send(json_encode($this->logs));
        }
    }

    public function onMessage(Conn $from, $msg) {
        global $clients;
        $msg = preg_replace('/^\/chat /', '', $msg, 1);
        $json = @json_decode($msg);
        if ($json && !empty($json->isApi)) {
            if (empty($from->username) && !empty($json->session)) {
                $from->user_id = 1; // TODO
                $from->username = 'rann'; // TODO
                $from->sessionId = $json->session;
                echo "{$from->resourceId} authenticated as {$from->username}";
            }
        } elseif (!empty($from->username)) { // Do we have a username for this user yet?
            // If we do, append to the chat logs their message
            $this->logs[] = array(
                "user" => $from->username,
                "msg" => $msg,
                "timestamp" => time()
            );
            // And send it
            $this->sendMessage(end($this->logs));
            // Don't let our logs get too full.
            if (count($this->logs) > AppConfig::$chatScrollback) {
                array_shift($this->logs);
            }
        } /*else {
            // If we don't this message will be their username
            $from->username = $msg;
        }*/
    }

    public function onClose(Conn $conn) {
        global $clients;
        // Detatch everything from everywhere
        $clients->detach($conn);
    }

    public function onError(Conn $conn, \Exception $e) {
        $conn->close();
        echo $e->getMessage() . "\n";
    }

    private function sendMessage($message) {
        global $clients;
        foreach ($clients as $user) {
            $user->send(json_encode($message));
        }
    }
}