<?php
/**
 * BaseController for the site
 * @author: Raysmond
 * Date: 13-11-25
 */

class BaseController extends RController
{
    public function userCanAccessAction()
    {
        $roleId = Role::ANONYMOUS_ID;
        if(Rays::app()->isUserLogin())
            $roleId = Rays::app()->getLoginUser()->roleId;

        $definedRoleId = Role::ANONYMOUS_ID;
        $action = parent::getCurrentAction();
        if(isset($this->access[Role::ADMINISTRATOR]))
        {
            if(in_array($action,$this->access[Role::ADMINISTRATOR]))
                $definedRoleId = Role::ADMINISTRATOR_ID;
        }

        if(isset($this->access[Role::AUTHENTICATED]))
        {
            if(in_array($action,$this->access[Role::AUTHENTICATED]))
                $definedRoleId = Role::AUTHENTICATED_ID;
        }

        if(isset($this->access[Role::ANONYMOUS]))
        {
            if(in_array($action,$this->access[Role::ANONYMOUS]))
                $definedRoleId = Role::ANONYMOUS_ID;
        }

        if(isset($this->access[Role::VIP]))
        {
            if(in_array($action,$this->access[Role::VIP]))
                $definedRoleId = Role::VIP_ID;
        }

        //authority access allowance table (need authority , own authority)
        $authorityAllowTable = [
            [Role::ADMINISTRATOR_ID, Role::ADMINISTRATOR_ID],
            [Role::VIP_ID, Role::ADMINISTRATOR_ID], [Role::VIP_ID, Role::VIP_ID],
            [Role::AUTHENTICATED_ID, Role::ADMINISTRATOR_ID], [Role::AUTHENTICATED_ID, Role::VIP_ID], [Role::AUTHENTICATED_ID, Role::AUTHENTICATED_ID],
            [Role::ANONYMOUS_ID, Role::ADMINISTRATOR_ID], [Role::ANONYMOUS_ID, Role::VIP_ID], [Role::ANONYMOUS_ID, Role::AUTHENTICATED_ID], [Role::ANONYMOUS_ID, Role::ANONYMOUS_ID],
        ];

        return in_array([$definedRoleId, $roleId], $authorityAllowTable);
    }

    public function beforeAction($action)
    {
        Rays::logger()->attachHandler($this);
        return true;
    }

    public function page404()
    {
        Rays::app()->page404();
    }

    public function afterAction()
    {
        //$time = microtime(true);
        //echo '<center style="color: gray;padding: 10px;">'."Page generated in ".(($time-Rays::$startTime)*1000) . " ms"."</center>";

        $accessLog = new AccessLog();
        $accessLog->host = Rays::httpRequest()->getUserHostAddress();
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
                $sysLog->host = Rays::httpRequest()->getUserHostAddress();
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