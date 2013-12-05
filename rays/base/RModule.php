<?php
/**
 * RModule class file.
 * @author: Raysmond
 */

class RModule
{
    // The name of the module
    public $name;

    // The unique ID of the module
    private $_id;

    // The path of the module directory
    private $_path;

    static $moduleBaseUri = null;

    // The module shall appear in what pages
    // For example:
    // array('site/about','user/*')
    // * cannot be the first character
    // <front> for the front page
    public $access = array();

    public $denyAccess = array();

    public function __construct($params = array())
    {
        if (isset($params['id']))
            $this->setId($params['id']);

        if (isset($params['name']))
            $this->setName($params['name']);

        $this->init($params);
    }

    public static function getModuleBasePath()
    {
        if (static::$moduleBaseUri === null) {
            $basePath = substr(Rays::app()->getBasePath(), 1);
            $pos = strpos(Rays::app()->modulePath, $basePath) + strlen($basePath) + 1;
            static::$moduleBaseUri = Rays::app()->getBaseUrl() . '/' . substr(Rays::app()->modulePath, $pos);
        }
        return static::$moduleBaseUri;
    }

    /**
     * Initial function
     * You should override the method if you wanna do some initial work before
     * running the module
     */
    public function init($params = array())
    {

    }

    /**
     * Run the module
     * This is the place where the module output it's content
     */
    public function run()
    {
        if (!$this->denyAccess() && $this->canAccess()) {
            $content = $this->module_content();
            echo $content;
        } else
            return false;
    }

    /**
     * Module content method
     * This is the right place where you return the output content of the module
     * @return string
     */
    public function module_content()
    {
        return '';
    }

    public function getModuleDir()
    {
        if (!isset($this->_path)) {
            $this->_path = Rays::app()->modulePath . "/" . $this->getId();
        }
        return $this->_path;
    }

    public function getModulePath()
    {
        return static::getModuleBasePath() . '/' . $this->getId();
    }

    /**
     * Render a module view and get render content
     * @param string $viewFileName
     * @param string $data
     * @return string
     */
    public function render($viewFileName = '', $data = '')
    {
        $viewFile = $this->getModuleDir() . "/" . $viewFileName . ".view.php";
        if (file_exists($viewFile)) {
            if (is_array($data))
                extract($data);
            ob_start();
            ob_implicit_flush(false);
            require($viewFile);
            return ob_get_clean();
        } else {
            die("Module view file not exists: " . $viewFile);
        }
    }

    public function addCss($cssPath)
    {
        Rays::app()->getClientManager()->registerCss($cssPath);
    }

    public function addJs($jsPath)
    {
        Rays::app()->getClientManager()->registerScript($jsPath);
    }

    /**
     * Whether the current page can access the module
     */
    public function canAccess()
    {
        return Rays::app()->getHttpRequest()->urlMatch($this->access);
    }

    public function denyAccess()
    {
        return empty($this->denyAccess)? false : Rays::app()->getHttpRequest()->urlMatch($this->denyAccess);
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}