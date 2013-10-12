<?php
/**
 * UserController class file.
 * @author: Raysmond
 */

class UserController extends RController{
    public $layout = "index";
    public $defaultAction = "index";

    public function actionLogin(){
        $data = null;
        if($this->getHttpRequest()->isPostRequest()){
            $username = $this->getHttpRequest()->getParam("username");
            $password = $this->getHttpRequest()->getParam("password");
            $data = array("username"=>$username,"password"=>$password,"type"=>$this->getHttpRequest()->getRequestType());
        }
        $this->setHeaderTitle("Login");
        $this->addCss('/public/css/form.css');
        $this->render('login',$data,false);
    }
}