<?php
namespace Idler\Controller;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface as Conn;

class Chat {
    public static function onMessage(Conn $from, $msg) {
        global $clients;
        foreach ($clients as $client) {
            $client->send(self::_formatMessage($from, $msg));
        }
    }

    public static function _formatMessage(Conn $from, $msg) {
        return "<" . $from->resourceId . "> $msg";
    }
}