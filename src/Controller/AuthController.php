<?php

namespace Idler\Controller;

use Ratchet\ConnectionInterface as Conn;
use Idler\Controller\DefaultController;

class AuthController extends DefaultController
{
    public function onMessage(Conn $from, $msg) {
        $msg = json_decode($msg);
        if (!$msg) {
            return; // Invalid message
        }

        if (!empty($msg->session)) {
            if ($this->_validateSession($msg->session)) {
                $from->user_id = 1; // TODO
                $from->username = 'rann'; // TODO
                $from->sessionId = $msg->session;
                echo "{$from->resourceId} authenticated as {$from->username}\n";
            }
        }
    }

    private function _validateSession($sessionId) {
        return true; // TODO
    }

    public static function isValid(Conn $conn) {
        echo "Checking auth validity\n";
        // Get cookies from this client
        $cookies = $conn->WebSocket->request->getCookies();
        if (empty($cookies['ws_uid'])) {
            // Unauthenticated
        }
        // Get session data from main site

        return true;
    }

    public static function setCookies($cookies) {}

    public static function getUserIP() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        return filter_var($client, FILTER_VALIDATE_IP) ? $client : filter_var($forward, FILTER_VALIDATE_IP) ? $forward : $_SERVER['REMOTE_ADDR'];
    }

    public static function isAuthenticated(Conn $conn) {
        return true;
    }
}