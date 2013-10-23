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
    public $viewPath;
    public $layoutPath;
    public $modulePath;
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

        Rays::setApplication($this);

        $this->modelPath = MODEL_PATH;
        $this->controllerPath = CONTROLLER_PATH;
        $this->viewPath = VIEW_PATH;
        $this->layoutPath = VIEW_PATH;
        $this->modulePath = MODULES_PATH;

        if (isset($config['modelPath']))
            $this->modelPath = $config['modelPath'];

        if (isset($config['controllerPath']))
            $this->controllerPath = $config['controllerPath'];

        if (isset($config['viewPath']))
            $this->viewPath = $config['viewPath'];

        if (isset($config['layoutPath']))
            $this->layoutPath = $config['layoutPath'];

        if (isset($config['modulePath']))
            $this->layoutPath = $config['modulePath'];

        if (isset($config['defaultController']))
            $this->defaultController = $config['defaultController'];

        if (isset($config['layout']))
            $this->layout = $config['layout'];

        if (isset($config['isCleanUri']))
            $this->isCleanUri = $config['isCleanUri'];
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
     * @param $route array router information
     */
    private function runController($route = array())
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
            $_controller->runAction($this->router->getAction(), $this->router->getParams());
        } else {
            // No controller found
            // die("Controller(" . $_controller . ") not exists....");
            $this->page404();
        }
    }

    /**
     * Show 404 page.
     */
    public function page404()
    {
        $controller = new RController();
        $controller->render("404");
    }

    /**
     * Get http request handler
     * @return mixed
     */
    public function getHttpRequest()
    {
        return $this->httpRequestHandler;
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
            $user = new User();
            $user->load($id);
            $user->role->load();
            return $user;
        } else return null;
    }

    public function isUserLogin()
    {
        return $this->getHttpSession()->get("user") != false;
    }

    public function isCleanUri()
    {
        return $this->isCleanUri != false;
    }


}