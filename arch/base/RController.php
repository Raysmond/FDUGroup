<?php
/**
 * RController class file.
 * @author: Raysmond
 */

/**
 * Class RController
 * This is the base controller for all controllers in the framework.
 */
class RController
{
    // the layout for the controller
    public $layout = "index";

    // default action is provided if there's no action requested from the URL
    public $defaultAction = "index";

    private $_action;
    private $_params;

    // the unique ID of the controller
    private $_id = '';

    public function __construct($id = null)
    {
        if ($id != null)
            $this->_id = $id;
    }


    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get controller file
     */
    public function getControllerFile()
    {
        $controller = ucfirst(getId() . "Controller");
        $controllerFile = Rays::app()->controllerPath . "/" . $controller . ".php";
        if (file_exists($controllerFile)) {
            return $controllerFile;
        } else return false;
    }

    /**
     * Get layout file.
     * @param $layoutName
     * @return the layout file name or false if the file not exists
     */
    public function getLayoutFile($layoutName)
    {
        $viewFile = Rays::app()->viewPath . "/" . "layout/" . $layoutName . ".php";
        if (file_exists($viewFile))
            return $viewFile;
        else
            return false;
    }

    /**
     * @param string $content
     * @param bool $return
     * @return string
     */
    public function renderContent($content = '', $return = false)
    {
        $output = '';
        if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
            $output = $this->renderFile($layoutFile, array('content' => $content), true);
        if ($return)
            return $output;
        else
            echo $output;
    }

    /** Render a view
     * @param string $view the name of the view to be rendered
     * @param null $data
     * @param bool $return
     * @return mixed
     */
    public function render($view, $data = null, $return = false)
    {
        $output = $this->renderPartial($view, $data, true);
        if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
            $output = $this->renderFile($layoutFile, array('content' => $output), true);
        if ($return)
            return $output;
        else
            echo $output;
    }

    public function renderPartial($view, $data, $return = false)
    {
        if (($viewFile = $this->getViewFile($view)) != false) {
            $content = $this->renderFile($viewFile, $data, true);
            if ($return)
                return $content;
            else
                echo $content;
        } else {
            die("Cannot find the requested view file: " . $viewFile);
        }
    }

    public function renderFile($fileName, $data, $return = false)
    {
        if (is_array($data))
            extract($data);

        if ($return) {
            ob_start();
            ob_implicit_flush(false);
            require($fileName);
            return ob_get_clean();
        } else require($fileName);

    }

    /**
     * Get view file
     * @param $viewName
     * @return string the file name of the view or false if the file not exists
     */
    public function getViewFile($viewName)
    {
        $viewFile = Rays::app()->viewPath . "/" . $this->getId() . "/" . $viewName . ".php";
        if (file_exists($viewFile))
            return $viewFile;
        else
            return false;
    }

    public function beforeAction($action)
    {
        return true;
    }

    /**
     * Run an antion
     * @param $action string action ID
     * @param $params array parameters
     */
    public function runAction($action, $params)
    {
        $this->setCurrentAction($action);
        $this->setActionParams($params);

        if ($this->beforeAction($action) == false) {
            return;
        }

        $methodName = $this->generateActionMethod();
        $len = count($this->_params);

        // It's shame to run action methods this way,
        // but I didn't figure out other better way
        if (method_exists($this, $methodName)) {
            $p = $this->_params;
            if ($len == 0)
                $this->$methodName();
            else if ($len == 1)
                $this->$methodName($p[0]);
            else if ($len == 2)
                $this->$methodName($p[0], $p[1]);
            else if ($len == 3)
                $this->$methodName($p[0], $p[1], $p[1]);
            else if ($len == 4)
                $this->$methodName($p[0], $p[1], $p[2], $p[3]);
            else if ($len == 5)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4]);
            else if ($len == 6)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4], $p[5]);
            else if ($len == 7)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6]);
            else if ($len == 8)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7]);
            else if ($len == 9)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8]);
            else if ($len == 10)
                $this->$methodName($p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7], $p[8], $p[9]);
            else
                die("Too many parameters...");
        } else {
            Rays::app()->page404();
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
     * Set header title for the page
     * <title></title>
     * @param $title
     */
    public function setHeaderTitle($title)
    {
        Rays::app()->getClientManager()->setHeaderTitle($title);
    }

    /**
     * Get current action
     * @return mixed
     */
    public function getCurrentAction()
    {
        return $this->_action;
    }

    /**
     * Set current action
     * @param $action
     */
    public function setCurrentAction($action)
    {
        $this->_action = $action;
        if (!isset($this->_action)) {
            $this->_action = $this->defaultAction;
        }
    }

    /**
     * Get action params array
     * @return params array
     */
    public function getActionParams()
    {
        return $this->_params;
    }

    /**
     * Set parameters for the current action
     * @param $params
     */
    public function setActionParams($params)
    {
        $this->_params = $params;
        if ($this->_params == null)
            $this->_params = array();
    }

    /**
     * Generate action method name through action ID
     * For example:
     * action ID = 'view', generated method name = 'actionView'
     * @return string
     */
    public function generateActionMethod()
    {
        return "action" . ucfirst($this->_action);
    }

    /**
     * Get http request handler
     * @return mixed
     */
    public function getHttpRequest()
    {
        return Rays::app()->getHttpRequest();
    }

    /**
     * Redirect to a new URL
     * @param $url
     */
    public function redirect($url)
    {
        header('location: ' . $url);
    }

    public function redirectAction($controller = '', $action = '', $params)
    {
        if ($controller == '') $controller = $this->getId();
        header('location: ' . RHtmlHelper::siteUrl($this->generateActionLink($controller, $action, $params)));
    }


    /**
     * Generate action link
     * @param $controller
     * @param $action
     * @param $params action parameters
     * @return string action link
     */
    public function generateActionLink($controller, $action, $params)
    {
        if ($controller == null)
            $controller = $this->getId();
        $link = "?q=" . $controller;
        if (isset($action) && $action != '')
            $link .= "/" . $action;
        if (isset($params)) {
            if (!is_array($params)) {
                $link .= "/" . $params;
            } else {
                foreach ($params as $param) {
                    $link .= "/" . $param;
                }
            }
        }
        return RHtmlHelper::tryCleanLink($link);
    }

    /**
     * Get session manager
     * @return mixed
     */
    public function getSession()
    {
        return Rays::app()->getHttpSession();
    }

    /**
     * Set flash messages
     * @param $key "message","warinng","error"
     * @param $message
     */
    public function flash($key,$message)
    {
        $this->getSession()->flash($key,$message);
    }

    /**
     * @param $moduleId
     * @param array $params
     */
    public function createModule($moduleId, $params = array())
    {
        Rays::importModule($moduleId);
        $moduleClass = $moduleId . "_module";
        $module = new $moduleClass($params);
        $module->setId($moduleId);
        $module->init();
        return $module;
    }

    /**
     * Creates a module and run it
     * @param $moduleId the unique name of the module
     * @param array $params module properties array
     * @param bool $return whether or not return the output content
     * @return mixed
     */
    public function module($moduleId, $params = array(), $return = false)
    {
        $module = $this->createModule($moduleId, $params);
        if ($return) {
            ob_start();
            ob_implicit_flush(false);
            $module->run();
            return ob_get_clean();
        } else {
            $module->run();
        }
    }
}