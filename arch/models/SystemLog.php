<?php
/**
 * System log data model class
 * @author: Raysmond
 * Date: 13-11-26
 */

class SystemLog extends Data{

    public $id,$type,$userId,$message,$severity,$path,$referrerUri,$host,$timestamp;


    public function __construct()
    {
        $options = array(
            'key' => 'id',
            'table' => 'syslog',
            'columns' => array(
                'id' => 'log_id',
                'type' => 'type',
                'userId' => 'u_id',
                'message' => 'message',
                'severity' => 'severity',
                'host' => 'host',
                'path' => 'path',
                'referrerUri' => 'referer_uri',
                'timestamp' => 'timestamp'
            )
        );
        parent::init($options);
    }

    public function insert()
    {
        if (!isset($this->timestamp) || $this->timestamp === '') {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return parent::insert();
    }

} 