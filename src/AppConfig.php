<?php
namespace Idler;

use Idler\DefaultAppConfig;

class AppConfig extends DefaultAppConfig
{
    public static $domain = 'localhost';
    public static $port = 8080;
    public static $authEndpoint = 'ws.firepoweredgaming.dev/ws_auth.php';
    public static $chatScrollback = 5; // # of lines to store for new connects
    public static $db = array(
        'server' => 'localhost',
        'user' => '',
        'password' => ''
    );
}