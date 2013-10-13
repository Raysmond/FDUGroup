<?php
/**
 * Config file
 * @author: Raysmond
 */

return array(
    // the title of the web application
    'name' => 'FDUGroup',

    // database configuration
    'db' => array(
        'host' => 'localhost',
        'user' => 'fdugroup',
        'password' => 'fdugroup',
        'db_name' => 'fdugroup',
        'table_prefix' => '',
        'charset' => 'utf8',
    ),


    'baseUrl' => "http://localhost/FDUGroup",

    'isCleanUri' => true,

    'defaultController' => 'site',

    'defaultAction' => 'index',

    'cache' => array(
        'cache_dir' => 'cache',
        'cache_prefix' => "cache_",
        'cache_time' => 1800, //seconds
    )
);