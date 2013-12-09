<?php
/**
 * AccessLog data model
 *
 * @author: Raysmond
 */

class AccessLog extends RModel
{

    public $id, $userId, $host, $title, $path, $uri, $timestamp = null;

    public static $primary_key = "id";
    
    public static $table = "accesslog";

    public static $mapping = array(
        'id' => 'aid',
        'userId' => 'u_id',
        'host' => 'host',
        'title' => 'title',
        'path' => 'path',
        'uri' => 'uri',
        'timestamp' => 'timestamp'
    );
}