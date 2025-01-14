<?php

class PDOMySQLConnector
{
    private static $mysqlClient;

    public static function getClient()
    {
        if (self::$mysqlClient == null) {
            self::$mysqlClient = new PDO('mysql:host=localhost;dbname=UserStories;charset=utf8', 'webserv', '8331chrC');
        }
        return self::$mysqlClient;
    }
}