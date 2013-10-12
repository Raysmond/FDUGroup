<?php
/**
 * RRouter class file
 * @author: Raysmond
 *
 * In order to resolve the query uri, first of all we have to normalize the query uri.
 * In this framework, I have made an agreement on the form of the query uri.
 * For example:
 * http://localhost/FDUGroup/?q=site/view/12
 * This is a common form. Based on this kind of form, the router analyse the uri and
 * set controller = "site", action = "view", parameters = 12. so the router url array is
 * array(
 *  'controller' => "site",
 *  'action' => "view",
 *  'params' => array(
 *      [0] => 12,
 *  )
 * )
 * Of course, if there are more than one parameter, than the other parameters will be added
 * to the array of 'params'.
 */

class RRouter
{
    // query url
    public $queryUrl;

    /**
     * @var array normalized route uri array
     */
    private $_routeUrl = array();

    private $_controller;
    private $_action;
    private $_params;


    public function __construct()
    {
        $this->queryUrl = parse_url($_SERVER['REQUEST_URI']);
    }

    public function getRouteUrl()
    {
        $this->processUrl();
        return $this->_routeUrl;
    }

    public function setRouteUrl($route)
    {
        $this->_routeUrl = $route;
    }

    public function processUrl()
    {
        // what if there're more url types
        $this->processQueryUrl();
    }

    /**
     * Processes the query uri and transforms the params into route
     */
    public function processQueryUrl()
    {
        $query = Rays::app()->getHttpRequest()->getQuery("q");
        $queryArr = explode('/', $query);
        $route = array();

        $len = count($queryArr);
        if ($len > 0) {
            $this->_controller = $route['controller'] = $queryArr[0];
        }
        if ($len > 1) {
            $this->_action = $route['action'] = $queryArr[1];
        }
        if ($len > 2) {
            $route['params'] = array();
            for ($i = 2; $i < $len; $i++) {
                if(isset($queryArr[$i])&&$queryArr[$i]!='')
                $route['params'][$i - 2] = $queryArr[$i];
            }
            $this->_params = $route['params'];
        }
        $this->setRouteUrl($route);
    }

    /**
     * Get controller from route
     * @return controller ID or null if no controller is provided from the query uri
     */
    public function getController()
    {
        return isset($this->_controller) ? $this->_controller : null;
    }

    /**
     * Get action from route
     * @return string action ID or null if no action is provided from the query uri
     */
    public function getAction()
    {
        return isset($this->_action) ? $this->_action : null;
    }

    /**
     * Get parameters array from route
     * @return array params
     */
    public function getParams()
    {
        return $this->_params;
    }

}