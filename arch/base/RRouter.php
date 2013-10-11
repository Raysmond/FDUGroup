<?php
/**
 * RRouter class file
 * @author: Raysmond
 */

class RRouter
{
    // query url
    public $queryUrl;

    private $_routeUrl = array();

    public function __construct()
    {
        $this->queryUrl = parse_url($_SERVER['REQUEST_URI']);
    }

    public function getRouteUrl()
    {
        $this->processUrl();
        return $this->_routeUrl;
    }

    public function processUrl()
    {
        // what if there're more url types
        $this->processQueryUrl();
    }

    public function processQueryUrl()
    {
        $arr = !empty ($this->queryUrl['query']) ? explode('&', $this->queryUrl['query']) : array();
        $array = $tmp = array();
        if (count($arr) > 0) {
            foreach ($arr as $item) {
                $tmp = explode('=', $item);
                $array[$tmp[0]] = $tmp[1];
            }

            if (isset($array['controller'])) {
                $this->_routeUrl['controller'] = $array['controller'];
                unset($array['controller']);
            }
            if (isset($array['action'])) {
                $this->_routeUrl['action'] = $array['action'];
                unset($array['action']);
            }
            if (count($array) > 0) {
                $this->_routeUrl['params'] = $array;
            }
        } else {
            $this->_routeUrl = array();
        }
    }
}