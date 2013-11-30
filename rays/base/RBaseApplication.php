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

    /**
     * The absolute base directory of the application class files
     * @var string
     */
    private $_baseDir = '';

    /**
     * The base path of the application class files. $_appPath is generated by program.
     * For example: The application 'index.php' locates at 'http://localhost/example', and the application class
     * files locate at 'http://localhost/example/app', then the $_appPath is '/example/app'
     * @var string
     */
    private $_appPath = '';

    /**
     * The base path of the application 'index.php' file
     * for example: /example  (the / at the beginning stands for the web server host like 'localhost')
     * @var string
     */
    private $_basePath = '';

    /**
     * The base URL of the application
     * @var
     */
    private $_baseUrl;

    private $_db;

    private $_config = array();

    private $_cache = array();

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
        if (isset($config['cache'])){
            $this->_cache = $config['cache'];
        }
        if(isset($config['baseDir'])){
            $this->_baseDir = $config['baseDir'];
        }
    }

    /**
     * Run the application
     */
    public function run()
    {
        date_default_timezone_set($this->timeZone);
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
            $this->_baseUrl = 'http://' . $_SERVER['SERVER_NAME'].(isset($this->_basePath)?$this->_basePath:"");
        }
        return $this->_baseUrl;
    }

    public function setBaseUrl($value)
    {
        $this->_baseUrl =  $value;
    }

    public function getAppPath()
    {
        if($this->_appPath===''){
            $pos = strpos($this->_baseDir,$this->_basePath);
            $this->_appPath = substr($this->_baseDir,$pos);
        }
        return $this->_appPath;
    }

    public function getBasePath()
    {
        return $this->_basePath;
    }

    public function setBasePath($path)
    {
        $this->_basePath = $path;
    }

    public function getBaseDir()
    {
        return $this->_baseDir;
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

    public function getDBPrefix()
    {
        return isset($this->_db['table_prefix'])?$this->_db['table_prefix']:"";
    }

    public function getCacheConfig(){
        return $this->_cache;
    }
}