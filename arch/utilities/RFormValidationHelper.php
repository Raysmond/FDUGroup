<?php
/**
 * RFormValidation helper class file.
 * @author: Raysmond
 */

// need to be implemented
class RFormValidationHelper
{
    protected $_fields = array();
    protected $_rules = array();
    protected $_errors = array();

    public function __construct($rules = array())
    {
        foreach ($rules as $rule) {
            if (!isset($rule['field']))
                continue;
            if (!isset($rule['label']))
                $rule['label'] = $rule['field'];
            if (!isset($rule['rules']))
                $rule['rules'] = '';
            $this->setRules($rule['field'], $rule['label'], $rule['rules']);
        }
    }

    public function setRules($field = '', $label = '', $rules = '')
    {
        if ($rules != '') {
            $rules = explode('|', $rules);
            for ($i = 0; $i < count($rules); $i++) {
                if (($pos = strpos('[', $rules[$i])) > 0) {
                    $rules[$i] = array(
                        'rule' => substr($rules[$i], 0, $pos),
                        'param' => substr($rules[$i], $pos + 1, strlen($rules[$i]) - $pos - 1)
                    );
                }
            }
        } else $rules = array();
        //$errors = array();
        //if(isset($rules['error'])&&!is_array($rules['error']))
        //    array_push($errors,$rules['error']);
        $rule = array(
            'field' => $field,
            'label' => $label,
            'rules' => $rules,
        );
        array_push($this->_fields, $field);
        array_push($this->_rules, $rule);
    }

    public function run()
    {
        $isValid = true;
        for ($i = 0; $i < count($this->_rules); $i++) {
            $rule = $this->_rules[$i];
            if (!empty($rule['rules'])) {
                foreach ($rule['rules'] as $r) {
                    if (is_array($r)) {
                        echo $r['rule'];
                        if (method_exists($this, $r) && ($this->$r['rule']($_POST[$rule['field']], $r['param']) == false)) {
                            $error = array();
                            $error[$r] = $rule['label'] . " not meet requirement \"" . $r['rule'] . "\"";
                            if(!isset($this->_errors[$rule['field']])) $this->_errors[$rule['field']] = array();
                            array_push($this->_errors[$rule['field']],$error);
                            $isValid = false;
                            continue;
                        }
                    } else {
                        if (!method_exists($this, $r) && function_exists($r))
                            $r($_POST[$rule['field']]);
                        else if (method_exists($this, $r) && ($this->$r($_POST[$rule['field']]) == false)) {
                            $error = array();
                            $error[$r] = $rule['label'] . " not meet requirement \"" . $r . "\"";
                            if(!isset($this->_errors[$rule['field']])) $this->_errors[$rule['field']] = array();
                            array_push($this->_errors[$rule['field']],$error);
                            $isValid = false;
                            continue;
                        }
                    }
                }
            }
        }
        return $isValid;
    }

    /**
     * Required rule
     * @param $str string
     * @return bool
     */
    public function required($str)
    {
        if (!is_array($str)) {
            return (trim($str) == '') ? false : true;
        } else
            return !empty($str);
    }

    public function regex_match($str, $regex)
    {
        return (!preg_match($regex, $str)) ? false : true;
    }

    public function equals($str, $field)
    {
        if (isset($_POST[$field]))
            return ($str == $field) ? true : false;
        else
            return false;
    }

    public function min_length($str, $len)
    {
        if (!$this->is_number($len))
            return false;
        return (strlen($str) < $len) ? false : true;
    }

    public function max_length($str, $len)
    {
        if (!$this->is_number($len))
            return false;
        return (strlen($str) > $len) ? false : true;
    }

    public function is_email($mail)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) ? false : true;
    }

    public function unique($str, $tableAndField = '')
    {
        if ($tableAndField == '' || !(strpos('.', $tableAndField) > 0))
            return false;
        $pos = strpos('.', $tableAndField);
        $tableName = substr($tableAndField, 0, $pos);
        $fieldName = substr($tableAndField, $pos + 1);
        if ($tableName == '' || $fieldName == '')
            return false;
        // need to be implemented
        // how to tell whether the field data is unique in the database

        return true;
    }

    public function is_number($val)
    {
        return preg_match("/[^0-9]/", $val) ? true : false;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

}