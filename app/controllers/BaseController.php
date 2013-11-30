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
        $accessLog = new AccessLog();
        $accessLog->host = $this->getHttpRequest()->getUserHostAddress();
        $accessLog->path = $this->getHttpRequest()->getRequestUriInfo();
        $accessLog->userId = Rays::app()->isUserLogin() ? Rays::app()->getLoginUser()->id : 0;;
        $accessLog->title = $this->getHeaderTitle();
        $accessLog->uri = $this->getHttpRequest()->getUrlReferrer();
        $accessLog->insert();
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
                $sysLog->userId = Rays::app()->isUserLogin() ? Rays::app()->getLoginUser()->id : 0;
                $sysLog->referrerUri = $this->getHttpRequest()->getUrlReferrer();
                $sysLog->path = $this->getHttpRequest()->getRequestUriInfo();
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
                $sysLog->insert();
                unset($sysLog);
            }
        }
    }
}