<?php
/**
 * Access log
 * @author: Raysmond
 * Date: 13-11-25
 */

class AccessLog extends Data
{

    public $id, $userId, $host, $title, $path, $uri, $timestamp = null;

    public function __construct()
    {
        $options = array(
            'key' => 'id',
            'table' => 'accesslog',
            'columns' => array(
                'id' => 'aid',
                'userId' => 'u_id',
                'host' => 'host',
                'title' => 'title',
                'path' => 'path',
                'uri' => 'uri',
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