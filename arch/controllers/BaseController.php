<?php
/**
 * BaseController for the site
 * @author: Raysmond
 * Date: 13-11-25
 */

class BaseController extends RController{

    public function afterAction()
    {
        $accessLog = new AccessLog();
        $accessLog->host = $this->getHttpRequest()->getUserHostAddress();
        $accessLog->path = $this->getHttpRequest()->getRequestUriInfo();
        $accessLog->userId = Rays::app()->isUserLogin()?Rays::app()->getLoginUser()->id: 0;
        $accessLog->title = $this->getHeaderTitle();
        $accessLog->uri = $this->getHttpRequest()->getUrlReferrer();
        $accessLog->insert();
    }
} 