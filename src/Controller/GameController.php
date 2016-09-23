<?php
namespace Idler\Controller;

use Ratchet\ConnectionInterface as Conn;
use Idler\Controller\DefaultController;
use Idler\Controller\AuthController;
use Idler\AppConfig;

class GameController extends DefaultController {
    private $_items;
    private $_skills;

    public function __construct($opts) {
        echo "Created new GameController\n";
        // Opts contain modules to load on init.
    }

    public function onOpen(Conn $conn) {
        // Todo: Fill user object with initial game data
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
        // DB save?
    }

    public function registerNewItem($itemSchema) {
        // Todo: Define a schema
        // ex: category, image, skill, price, attributes such as skill multipliers, the controller name
        // Maybe the item should have a use an event handler so interactivity between objects can be handled
    }

    public function registerNewSkill($skillSchema) {
        // What attributes does a skill need other than a name and image?
    }

}