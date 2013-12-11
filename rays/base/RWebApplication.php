<?php
/**
 * RWebApplication class file
 * User: Raysmond
 */

class RWebApplication extends RBaseApplication
{

    public $defaultController = 'site';
    public $layout = 'main';
    public $moduleFileExtension = ".module";

    /**
     * Whether or not user clean uri
     * For example:
     *  not a clean uri: http://localhost/FDUGroup/?q=site/about
     *  clean uri: http://localhost/FDUGroup/site/about
     * @var bool
     */
    public $isCleanUri = false;

    public $modelPath;
    public $controllerPath;
    public $modulePath;

    public $viewPath;
    public $layoutPath;

    public $controller;

    public $router;
    public $httpRequestHandler;
    public $clientManager;
    public $httpSession;

    // current login user
    public $user;

    public $flashMessage;

    public function init($config = null)
    {
        parent::init($config);

        $config = $this->getConfig();

        $this->modelPath = $this->getBaseDir().'/models';
        $this->controllerPath = $this->getBaseDir().'/controllers';
        $this->viewPath = $this->getBaseDir().'/views';
        $this->layoutPath = $this->getBaseDir().'/views/layout';
        $this->modulePath = $this->getBaseDir().'/modules';

        if (isset($config['defaultController']))
            $this->defaultController = $config['defaultController'];

        if (isset($config['layout']))
            $this->layout = $config['layout'];

        if (isset($config['isCleanUri']))
            $this->isCleanUri = $config['isCleanUri'];

        Rays::setApplication($this);

    }

    /**
     * The first method invoked by application
     */
    public function run()
    {
        parent::run();

        $this->clientManager = new RClient();
        $this->httpRequestHandler = new RHttpRequest();
        $this->router = new RRouter();

        $this->httpRequestHandler->normalizeRequest();
        $this->runController($this->router->getRouteUrl());

    }


    /**
     * Create and run the requested controller
     * @param array $route array router information
     */
    public function runController($route=array())
    {
        $_controller = '';
        if (isset($route['controller']) && $route['controller'] != '') {
            $_controller = $route['controller'] . "Controller";
        } else {
            $_controller = $this->defaultController . "Controller";
            $route['controller'] = $this->defaultController;
        }
        $_controller = ucfirst($_controller);

        if (class_exists($_controller)) {
            $_controller = new $_controller;
            $_controller->setId($route['controller']);
            $this->controller = $_controller;
            $action = isset($route['action'])?$route['action']:'';
            $params = isset($route['params'])?$route['params']:array();
            $_controller->runAction($action, $params);
        } else {
            // No controller found
            // die("Controller(" . $_controller . ") not exists....");
            $this->page404();
        }
    }

    /**
     * Run a controller action
     *
     * @param $controllerAction
     * for example:
     * runControllerAction('site/index',['arg1'])
     * </pre>
     *
     * @param array $params
     */
    public function runControllerAction($controllerAction,$params = array()){
        $route = $this->router->getRouteUrl($controllerAction);
        if(!is_array($params)){
            $params = array($params);
        }
        if(isset($route['params'])){
            $route['params'] = array_merge($route['params'], $params);
        }
        else
            $route['params'] = $params;
        self::runController($route);
    }

    /**
     * Show 404 page.
     */
    public function page404()
    {
        throw new RPageNotFoundException();
    }

    /**
     * Get http request handler
     * @return mixed
     */
    public function getHttpRequest()
    {
        return $this->httpRequestHandler;
    }

    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Get client manager
     * @return RClient
     */
    public function getClientManager()
    {
        return $this->clientManager;
    }

    /**
     * Get session manager
     * @return RSessionManager
     */
    public function getHttpSession()
    {
        if (!isset($this->httpSession)) {
            $this->httpSession = new RSessionManager();
        }
        return $this->httpSession;
    }

    /**
     * Return current login user
     * @return bool login user or false
     */
    public function getLoginUser()
    {
        if ($this->isUserLogin() && !isset($this->user)) {
            $id = $this->getHttpSession()->get("user");
            $this->user = User::find($id)->join("role")->first();
            return $this->user;
        }
        else if (isset($this->user)) {
            return $this->user;
        }
        else {
            return null;
        }
    }

    public function isUserLogin()
    {
        return $this->getHttpSession()->get("user") != false;
    }

    public function isCleanUri()
    {
        return $this->isCleanUri != false;
    }

    public function getController(){
        return $this->controller;
    }

}