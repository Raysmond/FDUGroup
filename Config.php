<?php
/**
 * Config file
 *
 * @author: Raysmond
 */

return array(
    'baseDir' => dirname(__FILE__),

    'name' => 'FDUGroup',

    'db' => array(
        'host' => 'localhost',
        'user' => 'fdugroup',
        'password' => 'fdugroup',
        'db_name' => 'fdugroup',
        'table_prefix' => 'group_',
        'charset' => 'utf8',
    ),

    'basePath' => "/FDUGroup",

    'isCleanUrl' => true,

    'defaultController' => 'site',

    'defaultAction' => 'index',

    'exceptionAction' => 'site/exception',

    'authProvider'=>'User',

    'cache' => array(
        'cache_dir' => '/cache',
        'cache_prefix' => "cache_",
        'cache_time' => 1800, //seconds
    )
);
