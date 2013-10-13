<?php
/**
 * RHttpRequest class file
 * @author: Raysmond
 */

class RHttpRequest
{

    public function normalizeRequest()
    {
        // normalize request
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
            if (isset($_GET))
                $_GET = $this->stripSlashes($_GET);
            if (isset($_POST))
                $_POST = $this->stripSlashes($_POST);
            if (isset($_REQUEST))
                $_REQUEST = $this->stripSlashes($_REQUEST);
            if (isset($_COOKIE))
                $_COOKIE = $this->stripSlashes($_COOKIE);
        }
    }

    public function stripSlashes(&$data)
    {
        if (is_array($data)) {
            if (count($data) == 0)
                return $data;
            $keys = array_map('stripslashes', array_keys($data));
            $data = array_combine($keys, array_values($data));
            return array_map(array($this, 'stripSlashes'), $data);
        } else
            return stripslashes($data);
    }

    public function isPostRequest()
    {
        return $this->getRequestType() == "POST";
    }

    public function getParam($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $defaultValue);
    }

    public function getQuery($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    public function getPost($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }

    public function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    public function getRequestType()
    {
        if (isset($_POST['_method']))
            return strtoupper($_POST['_method']);

        return strtoupper(isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET');
    }

    public function getIsAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }


    public function getServerName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public function getServerPort()
    {
        return $_SERVER['SERVER_PORT'];
    }


    public function getUrlReferrer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    }


    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }


    public function getUserHostAddress()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    }

    public function getUserHost()
    {
        return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : null;
    }


    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get useful request uri information form request uri
     * For example:
     * http://localhost/FDUGroup/?q=
     * @return string
     */
    public function getRequestUriInfo()
    {
        $uri = $this->getRequestUri();
        if (($pos = strpos($uri, "?q=")) > 0)
            return substr($uri, $pos + 3);
        else {
            $uri =  substr($uri, strlen(Rays::app()->getBaseUrl()) - strlen("http://" . $this->getServerName()) + 1);
            return str_replace("index.php","",$uri);
        }
    }

}