<?php
namespace Idler;

class DefaultAppConfig
{
    public static $domain = 'localhost';
    public static $port = 8080;
    public static $chatScrollback = 200; // # of lines to store for new connects
    public static $db = array(
        'server' => 'localhost',
        'user' => '',
        'password' => ''
    );
    public static $enabledSkills = array();
    public static $enabledItems = array();
}