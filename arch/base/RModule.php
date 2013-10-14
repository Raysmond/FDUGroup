<?php
/**
 * RModule class file.
 * @author: Raysmond
 */

class RModule
{
    // The name of the module
    public $name;

    // The unique ID of the module
    private $_id;

    // The path of the module directory
    private $_path;

    // The module shall appear in what pages
    // For example:
    // array('site/about','user/*')
    // * cannot be the first character
    // <front> for the front page
    public $access = array();

    public function __construct($params = array())
    {
        if (isset($params['id']))
            $this->setId($params['id']);

        if (isset($params['name']))
            $this->setName($params['name']);
    }

    /**
     * Initial function
     * You should override the method if you wanna do some initial work before
     * running the module
     */
    public function init()
    {

    }

    /**
     * Run the module
     * This is the place where the module output it's content
     */
    public function run()
    {
        if ($this->canAccess()) {
            $content = $this->module_content();
            echo $content;
        } else
            return false;
    }

    /**
     * Module content method
     * This is the right place where you return the output content of the module
     * @return string
     */
    public function module_content()
    {
        return '';
    }

    public function getModuleDir()
    {
        if (!isset($this->_path)) {
            $this->_path = Rays::app()->modulePath . "/" . $this->getId();
        }
        return $this->_path;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Whether the current page can access the module
     */
    public function canAccess()
    {
        if (!is_array($this->access))
            return false;
        // like : user/view/1
        $currentUrl = Rays::app()->getHttpRequest()->getRequestUriInfo();
        if($currentUrl=='') // front page
            $currentUrl = '<front>';
        foreach ($this->access as $url) {
            if ($url == $currentUrl)
                return true;
            else {
                if (($pos = strpos($url, '*')) > 0) {
                    $arr = explode('*', $url);
                    foreach ($arr as $part) {
                        if ($part == '') continue;
                        if (($apartPos = strpos($currentUrl, $part)) == false) {
                            $sub = substr($currentUrl, 0, strlen($part));
                            if ($sub != $part) {
                                return false;
                            } else {
                                $currentUrl = substr($currentUrl, strlen($part));
                            }
                        } else {
                            $currentUrl = substr($currentUrl, $apartPos + strlen($part));
                        }
                    }
                } else {
                    //
                }
            }
        }
        return true;
    }

}