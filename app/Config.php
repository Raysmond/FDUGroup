<?php
/**
 * Config file
 * @author: Raysmond
 */

return array(
    'baseDir' => dirname(__FILE__),

    // the title of the web application
    'name' => 'FDUGroup',

    // database configuration

    'db' => array(
        'host' => 'localhost',
        'user' => 'fdugroup',
        'password' => 'fdugroup',
        'db_name' => 'fdugroup',
        'table_prefix' => 'group_',
        'charset' => 'utf8',
    ),

    // online production database configuration

    /*
    'db' => array(
        'host' => '10.141.200.211',
        'user' => 'groups',
        'password' => '2013groups',
        'db_name' => 'fdugroup',
        'table_prefix' => 'group_',
        'charset' => 'utf8',
    ),
    */


    # 'baseUrl' => "http://localhost/FDUGroup",

    /*
     * The / at the beginning of the base Path stands for the base path of
     * the web host address like: localhost
     */
    'basePath' => "/FDUGroup",

    'isCleanUri' => true,

    'defaultController' => 'site',

    'defaultAction' => 'index',

    'exceptionAction' => 'site/exception',

    'cache' => array(
        'cache_dir' => '/cache',
        'cache_prefix' => "cache_",
        'cache_time' => 1800, //seconds
    )
);
