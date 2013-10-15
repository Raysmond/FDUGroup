<?php
/**
 * RWebApplication class file
 * User: Raysmond
 */

class RWebApplication extends RBaseApplication
{

    public $defaultController = 'site';

    public $layout = 'main';

    /**
     * @var array mapping from controller id to controller configuration
     * For example:
     * array(
     *    'post' => array(
     *         'class' = 'path.to.controller',
     *         'title' = 'the title'
     *     ),
     *    'user' => 'path.to.controller'
     * )
     */

    public $controllerMap = array();

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

    /**
     * Whether or not user clean uri
     * For example:
     *  not a clean uri: http://localhost/FDUGroup/?q=site/about
     *  clean uri: http://localhost/FDUGroup/site/about
     * @var bool
     */
    public $isCleanUri = false;

    public $moduleFileExtension = ".module";


    public function __construct($config = null)
    {
        parent::__construct($config);
        $config = $this->getConfig();

        Rays::setApplication($this);
        $this->clientManager = new RClient();

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
        $this->processRequest();
    }

    /**
     * Processes the request.
     * The request processing work is done here. It first resolves the request into
     * controller and action, and create a controller to invoke the corresponding action method
     */
    public function processRequest()
    {
        $this->httpRequestHandler = new RHttpRequest();
        $this->httpRequestHandler->normalizeRequest();

        $this->router = new RRouter();
        $this->runController($this->router->getRouteUrl());
    }

    public function runController($route)
    {
        $_controller = '';
        if (isset($route['controller']) && $route['controller'] != '') {
            $_controller = $route['controller'] . "Controller";
        } else {
            $_controller = $this->defaultController . "Controller";
            $route['controller'] = $this->defaultController;
        }
        $_controller = ucfirst($_controller);
        $controllerFile = $this->controllerPath . "/" . $_controller . ".php";

        if (class_exists($_controller)) {
            $_controller = new $_controller;
            $_controller->setId($route['controller']);
            $_controller->runAction($this->router->getAction(), $this->router->getParams());
        } else {
            // No controller found
            //die("Controller(" . $_controller . ") not exists....");
            $this->page404();
        }
    }

    /**
     * Show 404 page.
     */
    public function page404()
    {
        (new RController())->render('404');
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
        if($this->isUserLogin()){
            $id = $this->getHttpSession()->get("user");
            $user = new User();
            $user->load($id);
            return $user;
        }
        else return null;
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