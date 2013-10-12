<?php
/**
 * RBaseApplication class file
 * @author: Raysmond
 */

class RBaseApplication
{

    public $name = "My Application";

    public $charset = "UTF-8";

    private $_basePath;

    private $_baseUrl;

    private $_db;

    public function __construct($config = null)
    {

        if (is_string($config))
            $config = require($config);
        if (isset($config['name']))
            $this->name = $config['name'];
        if (isset($config['basePath']))
            $this->_basePath = $config['basePath'];
        if (isset($config['baseUrl']))
            $this->_baseUrl = $config['baseUrl'];
        if (isset($config['charset']))
            $this->charset = $config['charset'];
        if (isset($config['db']))
            $this->_db = $config['db'];
    }

    public function run()
    {
        //echo "application runs...";
    }

    public function getBasePath()
    {
        return $this->_basePath;
    }

    public function setBasePath($path)
    {
        if (($this->_basePath = realpath($path)) === false || !is_dir($this->_basePath)) {
            // no such path
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($_name)
    {
        $this->name = $_name;
    }

    public function getBaseUrl()
    {
        if (!isset($this->_baseUrl)) {
            $this->_baseUrl = 'http://' . $_SERVER['SERVER_NAME'];
        }
        return $this->_baseUrl;
    }

    public function setBaseUrl($value)
    {
        $this->_baseUrl = $value;
    }

    public function getDbConfig()
    {
        return $this->_db;
    }

    public function setDbConfig($db)
    {
        $this->_db = $db;
    }

    public function end($status=0){
        exit($status);
    }
}