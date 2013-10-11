<?php
/**
 * RController class file.
 * @author: Raysmond
 */

/**
 * Class RController
 * This is the base controller for all controllers in the framework.
 */
class RController
{
    // the layout for the controller
    public $layout = "main";

    // default action is provided if there's no action requested from the URL
    public $defaultAction = "index";

    // the unique ID of the controller
    private $_id;

    public function __construct($id=null){
        if($id!=null)
            $this->_id = $id;
    }


    public function setId($id){
        $this->_id = $id;
    }

    public function getId(){
        return $this->_id;
    }

    /**
     * Get controller file
     */
    public function getControllerFile(){
        $controller = ucfirst(getId()."Controller");
        $controllerFile = Rays::app()->controllerPath."/".$controller.".php";
        if(file_exists($controllerFile)){
            return $controllerFile;
        }
        else return false;
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

    /** Render a view
     * @param string $view the name of the view to be rendered
     * @param null $data
     * @param bool $return
     * @return mixed
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
        $viewFile = Rays::app()->viewPath . "/" .$this->getId(). "/" . $viewName . ".php";
        if (file_exists($viewFile))
            return $viewFile;
        else
            return false;
    }

}