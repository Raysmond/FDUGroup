<?php
/**
 * Ajax helper
 * @author: Raysmond
 */

class RAjaxHelper
{
    public $id;
    public $name;
    public $url;
    public $type = 'POST';
    public $params = array();

    // javascript function called before sending ajax request
    public $beforeSubmit;

    // javascript function called after ajax request returns
    public $callback;

    public $linkAttributes = array();

    const AJAX_CLASS = '_rays_ajax_action_';

    public function __construct($id = '', $name = '', $url = '', $type = 'POST', $params = array(), $beforeSubmit = '', $callback = '', $linkAttributes = array())
    {
        $this->id = trim($id);
        $this->name = trim($name);
        $this->url = trim($url);
        $this->type = trim($type);
        $this->params = $params;
        $this->beforeSubmit = trim($beforeSubmit);
        $this->callback = trim($callback);
        $this->linkAttributes = $linkAttributes;
    }

    public function html()
    {
        if (!isset($this->id) || $this->id == '') {
            if (!isset($this->linkAttributes['id'])) {
                $this->id = "ajax_action_" . rand(1000, 10000);
                $this->linkAttributes['id'] = $this->id;
            }
        }
        if(!isset($this->name)||$this->name==''){
            $this->name = "Ajax Action";
        }
        $this->linkAttributes['class'] = isset($this->linkAttributes['class']) ? (self::AJAX_CLASS . " " . $this->linkAttributes['class']) : self::AJAX_CLASS;
        $paramStr = urlencode(empty($this->params) ? '' : json_encode($this->params));
        $ajax = 'href="javascript:rays_ajax_post(\''.$this->url.'\',\''.$this->type.'\',\''.$paramStr.'\','.$this->beforeSubmit.','.$this->callback.')" ';
        $html = '<a ' . RHtmlHelper::parseAttributes($this->linkAttributes) .' '.$ajax. '>'.$this->name.'</a>';
        return $html;
    }
} 