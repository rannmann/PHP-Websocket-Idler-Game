<?php
namespace Idler;

class AppConfig
{
    public static $domain = 'localhost';
    public static $port = 8080;
    public static $authEndpoint = 'ws.firepoweredgaming.dev/ws_auth.php';
    public static $chatScrollback = 5; // # of lines to store for new connects
}