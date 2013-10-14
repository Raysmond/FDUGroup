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
        if (Rays::app()->isUserLogin()) {
            $this->flash("message", Rays::app()->getLoginUser()->name . ", you have already login...");
            $this->redirect(Rays::app()->getBaseUrl());
        }
        if ($this->getHttpRequest()->isPostRequest()) {
            $username = $this->getHttpRequest()->getParam("username");
            $password = $this->getHttpRequest()->getParam("password");
            $data = array("username" => $username);
            $login = $this->verifyLogin($username, $password);
            if ($login instanceof User) {
                $this->getSession()->set("user", $login->id);
                $this->flash("message", "Login successfully.");
                $this->redirect(Rays::app()->getBaseUrl());
            } else {
                $this->flash("message", $login);
            }
        }
        $this->setHeaderTitle("Login");
        $this->addCss('/public/css/form.css');
        $this->render('login', $data, false);
    }

    public function actionLogout()
    {
        if (Rays::app()->isUserLogin()) {
            $this->getSession()->deleteSession("user");
            $this->flash("message", "You have already logout.");
        }
        $this->redirect(Rays::app()->getBaseUrl());
    }

    public function actionView($userId)
    {
        $user = new User();
        $user->load($userId);
        if ($user == null) {
            // not found...
            // need to be implemented
            return;
        }
        $this->setHeaderTitle($user->name);
        $this->render('view', array('user' => $user), false);
    }

    public function actionRegister()
    {
        $this->setHeaderTitle("Register");
        $form = '';
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;
            // validate the form data
            $rules = array(
                array('field' => 'username', 'label' => 'User name', 'rules' => 'trim|required|min_length[5]|max_length[20]'),
                array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'),
                array('field' => 'password-confirm', 'label' => 'Password Confirm', 'rules' => 'trim|required|equals[password]'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|is_email','errors'=>array( ))
            );

            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                $user = new User();
                $user->setDefaults();
                $user->name = $form['username'];
                $user->password = md5($form['password']);
                $user->mail = $form['email'];
                $user->insert();
                $user = $user->find()[0];
                $this->flash("message","Hello,".$user->name.", please ".RHtmlHelper::linkAction('user','login','login')." !");
                $this->redirectAction('user', 'view', $user->id);
            }
            else{
                //echo '<pre>';
                //print_r($validation->getErrors());
                //echo '</pre>';
                $this->render('register',
                    array('validation_errors' => $validation->getErrors(),'registerForm'=>$form), false);
            }
        }
        else $this->render('register', null, false);
    }

    private function verifyLogin($username, $password)
    {
        $user = new User();
        $user->name = $username;
        $user = $user->find();
        if (count($user) == 0)
            return "No such user name.";
        $user = $user[0];
        $password = trim($password);
        if ($user->password == md5($password)) {
            return $user;
        } else return "User name and password not match...";
    }



    public function actionUserEdit($userId=null){
        if(Rays::app()->isUserLogin()==false){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
        }
        $user = new User();

        $user->load(($userId==null)?Rays::app()->getLoginUser()->id:$userId);
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            foreach($user->columns as $objCol=>$dbCol){
                if(isset($form[$objCol])){
                    $user->$objCol = $form[$objCol];
                }
            }
            $user->update();

        }

        if($user==null){
            // not found...
            // need to be implemented
            return;
        }
        $this->setHeaderTitle($user->name);
        $this->render('useredit',array('user'=>$user),false);
    }
}