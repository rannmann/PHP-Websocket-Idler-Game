<?php
namespace Idler\Controller;

//use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;
use Idler\Controller\DefaultController;
use Idler\Controller\AuthController;
use Idler\AppConfig;

class ChatController extends DefaultController {
    private $_logs;

    public function __construct() {
        $this->_logs = [];
        echo "Created new ChatController\n";
    }

    public function onOpen(Conn $conn) {
        //$this->_sendSystemMessage($conn, "Connected to chat.");
        if (AuthController::isValid($conn)) {
            $conn->send(json_encode($this->_logs));
        }
    }

    public function onMessage(Conn $from, $msg) {
        if (!AuthController::isAuthenticated($from)) {
            return;
        }
        $msg = preg_replace('/^\/chat /', '', $msg, 1);
        $json = @json_decode($msg);
        if (!empty($from->username)) { // Do we have a username for this user yet?
            // If we do, append to the chat logs their message
            $this->_logs[] = array(
                "user" => $from->username,
                "msg" => $msg,
                "timestamp" => time()
            );
            // And send it
            $this->_sendUserMessageToAll(end($this->_logs));
            // Don't let our logs get too full.
            if (count($this->_logs) > AppConfig::$chatScrollback) {
                array_shift($this->_logs);
            }
        } else { // This shouldn't happen.
            $this->_sendSystemMessage($from, "You are not authenticated.");
        }
    }

    public function onClose(Conn $conn) {
        $this->_sendSystemMessage($conn, "Disconnected from chat.");
    }

    private function _sendUserMessageToAll($message) {
        global $clients;
        foreach ($clients as $user) {
            $user->send(json_encode($message));
        }
    }
    private function _sendSystemMessage($to, $message) {
        $message = [
            "user" => "SYSTEM",
            "msg" => $message,
            "timestamp" => time()
        ];
        $to->send(json_encode($message));
    }
}