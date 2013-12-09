<?php
/**
 * System log data model class
 * @author: Raysmond
 * Date: 13-11-26
 */

class SystemLog extends RModel{

    public $id,$type,$userId,$message,$severity,$path,$referrerUri,$host,$timestamp;

    public static $primary_key = "id";

    public static $table = "syslog";

    public static $mapping = array(
        'id' => 'log_id',
        'type' => 'type',
        'userId' => 'u_id',
        'message' => 'message',
        'severity' => 'severity',
        'host' => 'host',
        'path' => 'path',
        'referrerUri' => 'referer_uri',
        'timestamp' => 'timestamp'
    );

}