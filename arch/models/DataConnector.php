<?php

class DataConnector
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection == null) {
            self::$connection = mysql_connect(
                Rays::app()->getDbConfig()['host'],
                Rays::app()->getDbconfig()['user'],
                Rays::app()->getDbconfig()['password']) or die(mysql_error());
            mysql_select_db(Rays::app()->getDbconfig()['db_name']) or die(mysql_error());
            mysql_query("set names " . Rays::app()->getDbconfig()['charset']) or die(mysql_error());
        }
        return self::$connection;
    }
}
