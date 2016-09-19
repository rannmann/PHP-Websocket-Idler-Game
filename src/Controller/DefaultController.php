<?php
namespace Idler\Controller;

use Ratchet\ConnectionInterface as Conn;

abstract class DefaultController {
    /**
     * New connection.  Initialize your stuff for this user.
     * @param  ConnectionInterface   $conn User connection
     */
    public function onOpen(Conn $conn) {}

    /**
     * New message to your route.  Handle it.
     * @param  ConnectionInterface   $conn User connection
     * @param  String $msg
     */
    public function onMessage(Conn $from, $msg) {}

    /**
     * This is called before or after a socket is closed (depends on how it's closed). SendMessage to $conn will not result in an error if it has already been closed.  Don't forge to save anything that should be in the database!
     * @param  ConnectionInterface   $conn User connection
     */
    public function onClose(Conn $conn) {}

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown, the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface   $conn User connection
     */
    public function onError(Conn $conn, \Exception $e) {}
}