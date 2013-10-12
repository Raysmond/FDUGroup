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
    public $controller;

    public $router;
    public $httpRequestHandler;

    public $clientManager;

    public function __construct($config = null)
    {
        parent::__construct($config);

        Rays::setApplication($this);

        $this->modelPath = MODEL_PATH;
        $this->controllerPath = CONTROLLER_PATH;
        $this->viewPath = VIEW_PATH;
        $this->layoutPath = VIEW_PATH;

        $this->clientManager = new RClient();

        if (isset($config['modelPath']))
            $this->modelPath = $config['modelPath'];

        if (isset($config['controllerPath']))
            $this->controllerPath = $config['controllerPath'];

        if (isset($config['viewPath']))
            $this->viewPath = $config['viewPath'];

        if (isset($config['layoutPath']))
            $this->layoutPath = $config['layoutPath'];

        if (isset($config['defaultController']))
            $this->defaultController = $config['defaultController'];

        if (isset($config['layout']))
            $this->layout = $config['layout'];
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
            die("Controller(" . $_controller . ") not exists....");
        }
    }

    public function getHttpRequest()
    {
        return $this->httpRequestHandler;
    }

    public function getClientManager()
    {
        return $this->clientManager;
    }

}