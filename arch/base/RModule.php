<?php
/**
 * RModule class file.
 * @author: Raysmond
 */

class RModule {
    // The name of the module
    public $name;

    // The unique ID of the module
    private $_id;

    // The path of the module directory
    private $_path;

    public function __construct($params=array()){
        if(isset($params['id']))
            $this->setId($params['id']);

        if(isset($params['name']))
            $this->setName($params['name']);
    }

    /**
     * Initial function
     * You should override the method if you wanna do some initial work before
     * running the module
     */
    public function init(){

    }

    /**
     * Run the module
     * This is the place where the module output it's content
     */
    public function run(){
        $content = $this->module_content();
        echo $content;
    }

    /**
     * Module content method
     * This is the right place where you return the output content of the module
     * @return string
     */
    public function module_content(){
        return '';
    }

    public function getModuleDir(){
        if(!isset($this->_path)){
            $this->_path = Rays::app()->modulePath."/".$this->getId();
        }
        return $this->_path;
    }

    public function setId($id){
        $this->_id = $id;
    }

    public function getId(){
        return $this->_id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

}