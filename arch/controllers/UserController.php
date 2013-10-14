<?php
/**
 * UserController class file.
 * @author: Raysmond
 */

class UserController extends RController
{
    public $layout = "index";
    public $defaultAction = "index";

    public function actionLogin()
    {
        $data = null;
        $session = Rays::app()->getHttpSession();
        if ($this->getHttpRequest()->isPostRequest()) {
            $username = $this->getHttpRequest()->getParam("username");
            $password = $this->getHttpRequest()->getParam("password");
            $data = array("username" => $username);
            $login = $this->verifyLogin($username, $password);
            if ($login instanceof User) {
                $session->set("user", $username);
                $session->flash("message", "Login successfully.");
                $this->redirect(Rays::app()->getBaseUrl());
            } else {
                $session->flash("message", $login);
            }
        }
        if($session->get("user")!=false){
            $session->flash("message",$session->get("user").", you have already login...");
        }
        $this->setHeaderTitle("Login");
        $this->addCss('/public/css/form.css');
        $this->render('login', $data, false);
    }

    public function actionLogout(){
        if(Rays::app()->isUserLogin()){
            $this->getSession()->deleteSession("user");
            $this->getSession()->flash("message","You have already logout.");
        }
        $this->redirect(Rays::app()->getBaseUrl());
    }

    public function actionView($userId){
        $user = new User();
        $user->load($userId);
        if($user==null){
            // not found...
            // need to be implemented
            return;
        }
        $this->setHeaderTitle($user->name);
        $this->render('view',array('user'=>$user),false);
    }

    public function actionRegister(){
        $this->setHeaderTitle("Register");
        $form = '';
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            // validate the form data
            $rules = array(
                array('field'=>'username','label'=>'User name','rules'=>'trim|required|min_length[5]|max_length[20]'),
                array('field'=>'password','label'=>'Password','rules'=>'trim|required|min_length[6]|max_length[20]'),
                array('field'=>'password-confirm','label'=>'Password Confirm','rules'=>'trim|required|equals[password]'),
                array('field'=>'email','label'=>'Email','rules'=>'trim|required|is_email')
            );
            $validation = new RFormValidation();
            if($validation->run()){
                $user = new User();
                $user->name = $form['username'];
                $user->password = $form['password'];
                $user->mail = $form['email'];
                $user->status = 1;
                date_default_timezone_set('PRC');
                $user->registerTime = date('Y-m-d H:i:s');
                $user->insert();
                $user = $user->find()[0];
                $this->redirectAction('user','view',$user->id);
            }
        }
        $this->render('register',array('registerForm'=>$form),false);
        // Rays::app()->getHttpRequest()->getParam('username');
        // need to be implemented
    }

    private function verifyLogin($username, $password)
    {
        $user = new User();
        $user->name = $username;
        $user = $user->find();
        if (count($user) == 0)
            return "No such user name.";
        $user = $user[0];
        if ($user->password == $password) {
            return $user;
        } else return "User name and password not match...";
    }
}