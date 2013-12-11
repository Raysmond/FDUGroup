<?php
/**
 * RClient class file.
 *
 * @author: Raysmond
 */

class RClient
{

    public $coreCss = array();

    public $css = array();

    public $coreScript = array();

    public $script = array();

    private $_headerTitle;

    public function registerCoreCss($cssPath)
    {
        if (!$this->isRegisteredCoreCss($cssPath)) {
            $this->coreCss[$cssPath] = $cssPath;
        }
    }

    public function registerCss($cssPath)
    {
        if (!$this->isRegisteredCss($cssPath)) {
            $this->css[$cssPath] = $cssPath;
        }
    }

    public function registerCoreScript($scriptPath)
    {
        if (!$this->isRegisteredCoreScript($scriptPath)) {
            $this->coreScript[$scriptPath] = $scriptPath;
        }
    }

    public function registerScript($scriptPath)
    {
        if (!$this->isRegisteredScript($scriptPath)) {
            $this->script[$scriptPath] = $scriptPath;
        }
    }

    public function isRegisteredCss($cssPath)
    {
        return isset($this->css[$cssPath]);
    }

    public function isRegisteredCoreCss($cssPath)
    {
        return isset($this->coreCss[$cssPath]);
    }

    public function isRegisteredScript($scriptPath)
    {
        return isset($this->script[$scriptPath]);
    }

    public function isRegisteredCoreScript($scriptPath)
    {
        return isset($this->coreScript[$scriptPath]);
    }

    public function getHeaderTitle()
    {
        if (!isset($this->_headerTitle)) {
            $this->_headerTitle = Rays::app()->getName();
        }
        return $this->_headerTitle . " | " . $this->_headerTitle = Rays::app()->getName();
    }

    public function setHeaderTitle($title)
    {
        $this->_headerTitle = $title;
    }
}