<?php
/**
 * Rays framework bootstrap file.
 * @author: Raysmond
 */

require(dirname(__FILE__) . '/RaysBase.php');

class Rays extends RaysBase{

    /**
     * Get the current login user or null for anonymous users
     * @return mixed
     */
    public static function user()
    {
        return static::app()->getLoginUser();
    }

    /**
     * Whether the user has login
     * @return mixed
     */
    public static function isLogin()
    {
        return static::app()->isUserLogin();
    }

    /**
     * Get router
     * @return mixed
     */
    public static function router()
    {
        return static::app()->getRouter();
    }

    /**
     * Get http request handler
     * @return mixed
     */
    public static function httpRequest()
    {
        return static::app()->getHttpRequest();
    }

    /**
     * Add js
     * @param $js javascript src like '/public/js/main.js' or 'http://example.com/example.js'
     */
    public static function js($js)
    {
        static::app()->getClientManager()->registerScript($js);
    }

    /**
     * Add css
     * @param $css css path like '/public/css/main.css' or 'http://example.com/example.css'
     */
    public static function css($css)
    {
        static::app()->getClientManager()->registerCss($css);
    }

    /**
     * Whether the current http request type is "POST"
     * @return mixed
     */
    public static function isPost()
    {
        return static::app()->getHttpRequest()->isPostRequest();
    }

    /**
     * Whether the current http request type is "Ajax"
     * @return mixed
     */
    public static function isAjax()
    {
        return static::app()->getHttpRequest()->getIsAjaxRequest();
    }

    /**
     * Get base url of the site
     * @return mixed
     */
    public static function baseUrl()
    {
        return static::app()->getBaseUrl();
    }

    /**
     * Get current url
     * @return mixed
     */
    public static function uri()
    {
        return static::app()->getHttpRequest()->getRequestUriInfo();
    }

    /**
     * Get URI referrer.(From which uri the request came)
     * @return mixed
     */
    public static function referrerUri()
    {
        return static::app()->getHttpRequest()->getUrlReferrer();
    }

    /**
     * Get request parameter
     * @param $name
     * @param $default
     * @return mixed
     */
    public static function getParam($name,$default)
    {
        return static::app()->getHttpRequest()->getParam($name,$default);
    }

}