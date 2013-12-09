<?php
/**
 * BaseController for the site
 * @author: Raysmond
 * Date: 13-11-25
 */

class BaseController extends RController
{
    public function beforeAction($action)
    {
        Rays::logger()->attachHandler($this);
        return true;
    }

    public function page404()
    {
        Rays::app()->page404();
        Rays::log('Page not found!', "warning", "system");
        Rays::logger()->flush();
    }

    public function afterAction()
    {
        //$time = microtime(true);
        //echo '<center style="color: gray;padding: 10px;">'."Page generated in ".(($time-Rays::$startTime)*1000) . " ms"."</center>";

        $accessLog = new AccessLog();
        $accessLog->host = $this->getHttpRequest()->getUserHostAddress();
        $accessLog->path = Rays::uri();
        $accessLog->userId = Rays::isLogin()? Rays::user()->id : 0;;
        $accessLog->title = $this->getHeaderTitle();
        $accessLog->uri = Rays::referrerUri();
        $accessLog->timestamp = date('Y-m-d H:i:s');
        $accessLog->save();
    }

    /**
     * 'onFlush' event handling.
     * This method will be called when the 'flush' method of RLog is called
     * like: <pre>Rays::logger()->flush();</pre>
     * @param $event event object
     */
    public function onFlush($event)
    {
        $logs = $event->getParams();
        if (!empty($logs)) {
            foreach ($logs as $log) {
                $sysLog = new SystemLog();
                $sysLog->host = $this->getHttpRequest()->getUserHostAddress();
                $sysLog->userId = Rays::isLogin()? Rays::user()->id : 0;
                $sysLog->referrerUri = Rays::referrerUri();
                $sysLog->path = Rays::uri();
                $sysLog->timestamp = $log['timestamp'];
                $sysLog->message = $log['message'];

                $level = null;
                switch ($log['level']) {
                    case RLog::LEVEL_ERROR:
                        $level = 2;
                        break;
                    case RLog::LEVEL_INFO:
                        $level = 0;
                        break;
                    case RLog::LEVEL_WARNING:
                        $level = 1;
                        break;
                }
                if ($level === null) continue;
                $sysLog->severity = $level;
                $sysLog->type = $log['type'];
                $sysLog->save();
                unset($sysLog);
            }
        }
    }

    public function getPage($key, $default = 1)
    {
        $page = Rays::getParam($key, $default);
        if (!is_numeric($page) || $page < 1) {
            $page = 1;
        }
        return $page;
    }

    const DEFAULT_PAGE_SIZE = 10;

    public function getPageSize($key, $default = BaseController::DEFAULT_PAGE_SIZE)
    {
        $size = Rays::getParam($key, $default);
        if (!is_numeric($size) || $size < 1) {
            $size = DEFAULT_PAGE_SIZE;
        }
        return $size;
    }
}