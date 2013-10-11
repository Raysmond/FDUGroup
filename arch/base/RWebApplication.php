<?php
/**
 * RWebApplication class file
 * User: Raysmond
 */

class RWebApplication extends RBaseApplication{

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

    public function __construct($config=null){
        parent::__construct($config);

        Rays::setApplication($this);

        $this->modelPath = MODEL_PATH;
        $this->controllerPath = CONTROLLER_PATH;
        $this->viewPath = VIEW_PATH;
        $this->layoutPath = VIEW_PATH;

        if(isset($config['modelPath']))
            $this->modelPath = $config['modelPath'];

        if(isset($config['controllerPath']))
            $this->controllerPath = $config['controllerPath'];

        if(isset($config['viewPath']))
            $this->viewPath = $config['viewPath'];

        if(isset($config['layoutPath']))
            $this->layoutPath = $config['layoutPath'];

        if(isset($config['controller']))
            $this->controller = $config['controller'];

        if(isset($config['defaultController']))
            $this->defaultController = $config['defaultController'];

        if(isset($config['layout']))
            $this->layout = $config['layout'];
    }

    /**
     * Processes the request.
     * The request processing work is done here. It first resolves the request into
     * controller and action, and create a controller to invoke the corresponding action method
     */
    public function processRequest(){
        $this->router = new RRouter();
        $routerUrl = $this->router->getRouteUrl();
        $this->runController($routerUrl);
    }

    public function runController($route){
        $this->createController($route);
    }

    /**
     * Create a concrete controller
     * @param array $route array contains URL request information
     */
    public function createController($route){
        $_controller = '';
        $_model = '';
        $_action = '';
        $_params = '';

        if(isset($route['controller'])&&$route['controller']!=''){
            $_controller = $route['controller']."Controller";
        }
        else{
            $_controller = $this->defaultController."Controller";
            $route['controller'] = $this->defaultController;
        }
        $_controller = ucfirst($_controller);

        if(isset($route['action'])&&$route['action']!=''){
            $_action = $route['action'];
        }

        if(isset($route['params'])&&$route['params']!=''){
            $_params = $route['params'];
        }
        $controllerFile = $this->controllerPath."/".$_controller.".php";

        if(is_file($controllerFile)&&class_exists($_controller)){
            $_controller = new $_controller;
            $_controller->setId($route['controller']);
            // If no action is provided by the URL,
            // set it to the default action of the controller
            if(!isset($_action)||$_action==""){
                if(isset($_controller->defaultAction))
                    $_action = $_controller->defaultAction;
            }
            $_action = "action".ucfirst($_action);

            if(isset($_action)){
                if(method_exists($_controller, $_action)){
                    if(isset($_params)){
                        $_controller->$_action($_params);
                    }
                    else{
                        $_controller->$_action();
                    }
                }
                else{
                    die("Controller method not exists...");
                }
            }
        }
        else{
            die("Controller(".$_controller.") not exists....");
        }
    }


    /**
     * The first method invoked by application
     */
    public function run(){
        parent::run();
        $this->processRequest();
    }

}