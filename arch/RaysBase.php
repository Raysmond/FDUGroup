<?php
/**
 * Base framework bootstrap file
 * @author: Raysmond
 */

define('SYSTEM_PATH', dirname(__FILE__));

define('SYSTEM_CORE_PATH', SYSTEM_PATH . '/base');

define('CONTROLLER_PATH', SYSTEM_PATH . '/controllers');

define('MODEL_PATH', SYSTEM_PATH . '/models');

define('VIEW_PATH', SYSTEM_PATH . '/views');

define('UTILITIES_PATH', SYSTEM_PATH . '/helpers');

define('MODULES_PATH', SYSTEM_PATH . '/modules');


/**
 * Class RaysBase is a basic helper class for common framework functionalities.
 * @author: Raysmond
 */
class RaysBase
{

    public static $classMap = array();

    public static $moduleMap = array();

    public static $imports = array();

    public static $_app;

    public static $copyright;

    public static $logger;

    public static $startTime;

    public static $_includePaths = array(
        CONTROLLER_PATH,
        MODEL_PATH,
        VIEW_PATH,
        SYSTEM_CORE_PATH,
        UTILITIES_PATH,
        MODULES_PATH,
    );

    public static function log($message,$level='info',$category='system')
    {
        static::$logger->log($message,$level,$category);
    }

    public static function logger()
    {
        return static::$logger;
    }

    public static function setApplication($app)
    {
        if (self::$_app === null && $app != null)
            self::$_app = $app;
        else {
            die("Application not found!");
        }
    }

    public static function app()
    {
        return self::$_app;
    }

    public static function createApplication($config)
    {
        static::$startTime = microtime(true);
        static::$logger = new RLog();

        return new RWebApplication($config);
    }

    public static function getFrameworkPath()
    {
        return SYSTEM_PATH;
    }

    public static function importModule($moduleId)
    {
        if (!isset(self::$moduleMap[$moduleId])) {
            $path = static::app()->modulePath . "/" . $moduleId . "/" . $moduleId . self::app()->moduleFileExtension;
            self::$moduleMap[$moduleId] = $path;
            require($path);
        }
    }

    public static function autoImports($imports = array())
    {
        foreach($imports as $import)
        {
            static::import($import);
        }
    }

    /**
     * Import custom PHP files
     *
     * @param $files files like: extension.file_name or extension.ext1.*
     * extension.file_name locates to extension/file_name.php
     * extension.ext1.* will import
     */
    public static function import($files)
    {
        $files = str_replace('.', '/', $files);
        if ($files) {
            $fileName = end(explode('/', $files));
            if ($fileName !== '*') {
                if (!isset(static::$imports[$files])) {
                    $path = static::getFrameworkPath() . '/' . $files . '.php';
                    if (is_file($path)) {
                        static::$imports[$files] = $path;
                        require($path);
                    }
                }
            } else {
                $files = str_replace('/*', '', $files);
                $dir = static::getFrameworkPath() . '/' . $files;
                if (is_dir($dir)) {
                    $dp = dir($dir);
                    while ($file = $dp->read()) {
                        if ($file != "." && $file != ".." && !is_dir($file)) {
                            if (end(explode('.', $file)) === 'php') {
                                $file_key = $files . '/' . $file;
                                $path = $dir . '/' . $file;
                                if (!isset(static::$imports[$file_key])) {
                                    static::$imports[$file_key] = $path;
                                    require($path);
                                }
                            }
                        }
                    }
                    $dp->close();
                }
            }
        }
    }

    /**
     * Class autoload loader
     * This method is invoked within an __antoload() magic method
     * @param string $className class name
     */
    public static function autoload($className)
    {
        if (isset(self::$classMap[$className]))
            require(self::$classMap[$className]);
        else {
            $className = end(explode("\\",$className));
            foreach (self::$_includePaths as $path) {
                $classFile = $path . DIRECTORY_SEPARATOR . $className . '.php';
                if (is_file($classFile)) {
                    require($classFile);
                    break;
                }
            }
        }
    }

    public static function getCopyright()
    {
        if (!isset(self::$copyright)) {
            return "© Copyright " . self::app()->name . " 2013, All Rights Reserved.";
        } else return self::$copyright;
    }
}

spl_autoload_register(array('RaysBase', 'autoload'));

header('Content-Type: text/html; charset=UTF-8');