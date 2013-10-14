<?php
/**
 * RFormValidation helper class file.
 * @author: Raysmond
 */

class RFormValidation
{
    protected $_fields = array();
    protected $_rules = array();
    protected $_errors = array();

    public function __construct($rules = array())
    {

    }

    public function setRules($field = '', $label = '', $rules = '')
    {

    }

    public function run()
    {

    }

    /**
     * Required rule
     * @param $str string
     * @return bool
     */
    public function required($str)
    {
        if(!is_array($str))
        {
            return (trim($str)=='')?false:true;
        }
        else
            return !empty($str);
    }

    public function regex_match($str,$regex)
    {
        return (!preg_match($regex,$str))?false:true;
    }

    public function equals($str,$field)
    {
        if(isset($_POST[$field]))
            return ($str==$field)?true:false;
        else
            return false;
    }

    public function min_length($str,$len)
    {

    }
}