<?php
/**
 * RExceptionHandler class file. It's the default exception handler.
 *
 * @author: Raysmond
 */

class RExceptionHandler {

    /**
     * Action in a controller which will be called to handle the exception
     * @var string
     */
    public static $exceptionAction = "";

    public static function setExceptionAction($action=''){
        self::$exceptionAction = $action;
    }

    /**
     * Handle exceptions, if no exception actions provided, default PHP 'print' method will be called
     *
     * @param Exception $e
     */
    public static function handleException(Exception $e)
    {
        if(self::$exceptionAction!=""){
            Rays::app()->runControllerAction(self::$exceptionAction,$e);
            return;
        }
        print "FDUGroup Exception: <br />";
        print $e;
    }
}