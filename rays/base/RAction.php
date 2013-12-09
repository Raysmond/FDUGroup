<?php
/**
 * RAction class file.
 * The base class for an action. An action can run called by a controller.
 *
 * @author: Raysmond
 */

abstract class RAction
{

    /**
     * The reference to the controller
     * @var object
     */
    private $controller;

    /**
     * The unique id of the action
     * @var string
     */
    private $id;

    /**
     * The parameters passed to the action
     * @var array
     */
    private $params = array();

    public function __construct($controller, $id='', $params = null)
    {
        $this->id = $id;
        $this->params = $params;
        $this->controller = $controller;
    }

    /**
     * Run the action. An actual action class must implement the method
     * @return mixed
     */
    abstract function run();

    public function getController()
    {
        return $this->controller;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParams()
    {
        return $this->params;
    }

} 