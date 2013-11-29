<?php
/**
 * RController class file.
 * This is the base controller for all controllers in the framework.
 * @author: Raysmond
 */

class RController
{
    // the layout for the controller
    public $layout = "index";

    // default action is provided if there's no action requested from the URL
    public $defaultAction = "index";

    // current action id
    private $_action;

    // Parameters passed to the action methd
    private $_params;

    // Header title within the <title> tag in HTML
    private $_headerTitle;

    /**
     * Define accessibility for actions, like restrict some actions only accessible
     * by administrators
     * @var array access definition array, for example:
     * array(
     *     "administrator"=>array("admin","edit"),
     *     "authenticated"=>array("edit")
     * )
     */
    public $access = array();

    // the unique ID of the controller
    private $_id = '';

    /**
     * Construction method
     * @param string $id the unique id of the controller
     */
    public function __construct($id='')
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
     * Render content directly
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
     * @param string $view the name of the view used to render the data
     * @param array/null $data data in array which need to be rendered
     * @param bool $return whether to return the rendered content or not
     * @return mixed the rendered content if $return=true or null
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

    /**
     * Render partial content without the layout
     * @param $view the name of the view file used to render the data
     * @param $data data in array which need to be rendered
     * @param bool $return whether to return the rendered content or not
     * @return string the rendered content if $return=true or null
     */
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

    /**
     * Render data with a view file
     * @param $fileName the name of the view file
     * @param $data data to be rendered
     * @param bool $return whether to return the rendered content or just print it
     * @return string rendered content if $return=true or null
     */
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

    /**
     * Method called before the runAction method
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        return true;
    }

    /**
     * Method called after the runAction method
     */
    public function afterAction()
    {

    }

    /**
     * Whether the current user has the right to view the page
     * @return bool
     */
    protected function userCanAccessAction()
    {
        $roleId = Role::ANONYMOUS_ID;
        if(Rays::app()->isUserLogin())
            $roleId = Rays::app()->getLoginUser()->roleId;

        $definedRoleId = Role::ANONYMOUS_ID;

        if(isset($this->access[Role::ADMINISTRATOR]))
        {
            if(in_array($this->_action,$this->access[Role::ADMINISTRATOR]))
                $definedRoleId = Role::ADMINISTRATOR_ID;
        }

        if(isset($this->access[Role::AUTHENTICATED]))
        {
            if(in_array($this->_action,$this->access[Role::AUTHENTICATED]))
                $definedRoleId = Role::AUTHENTICATED_ID;
        }

        if(isset($this->access[Role::ANONYMOUS]))
        {
            if(in_array($this->_action,$this->access[Role::ANONYMOUS]))
                $definedRoleId = Role::ANONYMOUS_ID;
        }

        if(isset($this->access[Role::VIP]))
        {
            if(in_array($this->_action,$this->access[Role::VIP]))
                $definedRoleId = Role::VIP_ID;
        }

        //authority access allowance table (need authority , own authority)
        $authorityAllowTable = [
            [Role::ADMINISTRATOR_ID, Role::ADMINISTRATOR_ID],
            [Role::VIP_ID, Role::ADMINISTRATOR_ID], [Role::VIP_ID, Role::VIP_ID],
            [Role::AUTHENTICATED_ID, Role::ADMINISTRATOR_ID], [Role::AUTHENTICATED_ID, Role::VIP_ID], [Role::AUTHENTICATED_ID, Role::AUTHENTICATED_ID],
            [Role::ANONYMOUS_ID, Role::ADMINISTRATOR_ID], [Role::ANONYMOUS_ID, Role::VIP_ID], [Role::ANONYMOUS_ID, Role::AUTHENTICATED_ID], [Role::ANONYMOUS_ID, Role::ANONYMOUS_ID],
        ];

        return in_array([$definedRoleId, $roleId], $authorityAllowTable);
    }

    /**
     * Run an action, handle the parameters(usually GET or POST method), interact with the data models
     * and decide whether to rendering a page in HTML or just return some content
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

        if(!$this->userCanAccessAction()){

            if(!Rays::app()->isUserLogin()){
                $this->flash("message","Please login first.");
                $this->redirectAction('user','login');
                return;
            }
            $this->flash("error","Sorry, you're not authorized to view the requested page.");
            Rays::app()->page404();
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
            else{
                // Pass the params array to the action
                $this->$methodName($p);
                //die("Too many parameters...");
            }

        } else {
            Rays::app()->page404();
            Rays::log("Page not found! On action matched.",RLog::LEVEL_WARNING,"system");
            Rays::logger()->flush();
        }
        $this->afterAction();
    }

    /**
     * Dispatch an action
     * @param string $actionPath the path of the action class
     * @param string $actionId the unique id of the target action
     * @return mixed
     * @throws RException
     */
    public function dispatchAction($actionId,$actionPath = ''){
        if($actionPath!==''){
            $className = end(explode(".",$actionPath));
            Rays::import($actionPath);
            if(class_exists($className)){
                $action = new $className($this,$actionId,$this->getActionParams());
                if(method_exists($action,"run")){
                    return $action->run();
                }else{
                    throw new RException("An action class must implements \'run\' method!");
                }
            }
            else{
                $file = Rays::getFrameworkPath().str_replace(".","/",$actionPath).".php";
                throw new RException("Class ($className) not exists. Class file: $file");
            }
        }
    }

    /**
     * Add a css asset file
     * @param $cssPath
     */
    public function addCss($cssPath)
    {
        Rays::app()->getClientManager()->registerCss($cssPath);
    }

    /**
     * Add a javascript asset file
     * @param $jsPath
     */
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
        $this->_headerTitle = $title;
        Rays::app()->getClientManager()->setHeaderTitle($title);
    }

    public function getHeaderTitle(){
        return $this->_headerTitle;
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
        exit;
    }

    /**
     * Redirect to a new action within a specific controller
     * @param string $controller the controller id
     * @param string $action the action id
     * @param $params parameters passed to the action
     */
    public function redirectAction($controller = '', $action = '', $params)
    {
        if ($controller == '') $controller = $this->getId();
        header('location: ' . RHtmlHelper::siteUrl($this->generateActionLink($controller, $action, $params)));
        exit;
    }


    /**
     * Generate an action link
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