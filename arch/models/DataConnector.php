<?php

class DataConnector
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection == null) {
            $dbConfig = Rays::app()->getDbConfig();
            self::$connection = mysql_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['password']) or die(mysql_error());
            mysql_select_db(Rays::app()->getDbconfig()['db_name']) or die(mysql_error());
            mysql_query("set names " . Rays::app()->getDbconfig()['charset']) or die(mysql_error());
        }
        return self::$connection;
    }
}
