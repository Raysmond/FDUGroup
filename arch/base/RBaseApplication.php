<?php
/**
 * RBaseApplication class file
 * @author: Raysmond
 */

class RBaseApplication
{

    public $name = "My Application";

    public $charset = "UTF-8";

    public $timeZone = 'PRC';

    private $_basePath;

    private $_baseUrl;

    private $_db;

    private $_config = array();

    public function __construct($config = null)
    {
        $this->init($config);
    }

    /**
     * Initialize the application with configurations
     * @param null $config
     */
    public function init($config = null)
    {
        $this->setConfig($config);
        $config = $this->getConfig();

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
        if (isset($config['timeZone']))
            $this->timeZone = $config['timeZone'];
    }

    /**
     * Run the application
     */
    public function run()
    {

    }

    /**
     * End the application
     * @param int $status
     */
    public function end($status = 0)
    {
        exit($status);
    }

    /**
     * Get the base URL of the application site
     * @return string
     */
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

    public function getDbConfig()
    {
        return $this->_db;
    }

    public function setDbConfig($db)
    {
        $this->_db = $db;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig($config)
    {
        if (is_string($config))
            $config = require($config);
        $this->_config = $config;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }
}