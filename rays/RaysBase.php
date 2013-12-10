<?php
/**
 * Base framework bootstrap file
 *
 * @author: Raysmond
 */

define('SYSTEM_PATH', dirname(__FILE__));

define('SYSTEM_CORE_PATH', SYSTEM_PATH . '/base');

define('HELPER_PATH', SYSTEM_PATH . '/helpers');



/**
 * Class RaysBase is a basic helper class for common framework functionality.
 *
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
        SYSTEM_PATH,
        SYSTEM_CORE_PATH,
        HELPER_PATH,
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
        if (static::$_app === null && $app != null){
            static::$_app = $app;
            static::initPath();
        }
        else {
            die("Application not found!");
        }
    }

    public static function app()
    {
        return static::$_app;
    }

    public static function createApplication($config)
    {
        static::$startTime = microtime(true);
        static::$logger = new RLog();

        return new RWebApplication($config);
    }

    public static function initPath()
    {
        static::$_includePaths[] = static::app()->controllerPath;
        static::$_includePaths[] = static::app()->modelPath;
        static::$_includePaths[] = static::app()->modulePath;
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
                    $path = static::app()->getBaseDir() . '/' . $files . '.php';
                    if (is_file($path)) {
                        static::$imports[$files] = $path;
                        require($path);
                    }
                }
            } else {
                $files = str_replace('/*', '', $files);
                $dir = static::app()->getBaseDir() . '/' . $files;
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
            return "© Copyright " . static::app()->name . " 2013, All Rights Reserved.";
        } else return self::$copyright;
    }
}

spl_autoload_register(array('RaysBase', 'autoload'));

set_exception_handler(array("RExceptionHandler", "handleException"));

header('Content-Type: text/html; charset=UTF-8');