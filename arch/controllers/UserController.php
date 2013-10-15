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
            return;
        }
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;
            $validation = new RFormValidationHelper(array(
                array('field'=>'username','label'=>'User name','rules'=>'trim|required'),
                array('field'=>'password','label'=>'password','rules'=>'trim|required')
            ));

            if($validation->run()){
                $login = $this->verifyLogin($form['username'], $form['password']);
                if ($login instanceof User)
                {
                    $this->getSession()->set("user", $login->id);
                    $this->flash("message", "Login successfully.");
                    $this->redirect(Rays::app()->getBaseUrl());
                    return;
                } else
                {
                    $this->flash("error", $login);
                    $data = array('loginForm'=>$form);
                }
            }
            else
            {
                $data = array('validation_errors' => $validation->getErrors(),'loginForm'=>$form);
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
                array('field' => 'username', 'label' => 'User name',
                    'rules' => 'trim|required|min_length[5]|max_length[20]' ),
                array('field' => 'password', 'label' => 'Password',
                    'rules' => 'trim|required|min_length[6]|max_length[20]'),
                array('field' => 'password-confirm', 'label' => 'Password Confirm',
                    'rules' => 'trim|required|equals[password]'),
                array('field' => 'email', 'label' => 'Email',
                    'rules' => 'trim|required|is_email')
            );

            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                $user = new User();
                $user->register($_POST['username'],md5($_POST['password']),$_POST['email']);
                $message = new Message();
                $message->sendMsg('system',0,$user->id,"Welcome, ".$user->name,
                    RHtmlHelper::encode("Dear ".$user->name." : <br/>Welcome to join the FDUGroup bit family!<br/><br/>--- FDUGroup team<br/>"),null,1);

                $this->flash("message","Hello,".$user->name.", please ".RHtmlHelper::linkAction('user','login','login')." !");
                $this->redirectAction('user', 'view', $user->id);
                return;
            }
            else{
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
            return;
        }
        $user = new User();

        $user->load(($userId==null)?Rays::app()->getLoginUser()->id:$userId);
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            foreach($user->columns as $objCol=>$dbCol){
                if(isset($form[$objCol])){
                    switch($objCol)
                    {
                        case "name":;
                        case "password":
                            if(preg_match("/^[a-zA-Z0-9_]+$/",$form[$objCol]) && strlen($form[$objCol]) > 4 && strlen($form[$objCol]) < 20)
                                $user->$objCol = $form[$objCol];break;
                        case "mail":;
                        case "weibo":
                            if(preg_match('/^[_.0-9a-z-a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/',$form[$objCol]))
                                $user->$objCol = $form[$objCol];break;
                        case "qq":;
                        case "mobile":
                            if(preg_match('/^[0-9]+$/',$form[$objCol]))
                                $user->$objCol = $form[$objCol];break;
                        default:     $user->$objCol = $form[$objCol];break;
                    }
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