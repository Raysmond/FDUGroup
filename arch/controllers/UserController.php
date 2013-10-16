<?php
/**
 * UserController class file.
 * @author: Raysmond
 */

class UserController extends RController
{
    public $layout = "index";
    public $defaultAction = "index";
    public $access = array(Role::AUTHENTICATED=>array('edit','logout'));

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
        $canEdit = false;
        $canAdd = false;
        $currentUser = Rays::app()->getLoginUser();
        if ($currentUser != null) {
            $friend = new Friend();
            $friend->uid = $currentUser->id;
            $friend->fid = $user->id;
            $canAdd = ($friend->load() == null);
            $canEdit = ($currentUser->id == $user->id);
        }

        $this->setHeaderTitle($user->name);
        $this->render('view', array('user' => $user, 'canEdit' => $canEdit, 'canAdd' => $canAdd), false);
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

    public function actionEdit($userId=null){

        $user = new User();

        //$user->load(($userId==null)?Rays::app()->getLoginUser()->id:$userId);
        // for now , the user can only edit his own profile
        $user->load(Rays::app()->getLoginUser()->id);
        $data = array('user'=>$user);

        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $config = array(
                array('field'=>'username','label'=>'User name','rules'=>'trim|required|min_length[5]|max_length[20]'),
            );
            // if set password, then go changing password
            if(isset($_POST['password'])&&($_POST['password']!=''))
            {
                array_push($config,array('field'=>'password','label'=>'New Password','rules'=>'trim|required|min_length[6]|max_length[20]'));
                array_push($config,array('field'=>'password-confirm','label'=>'New Password Confirm','rules'=>'trim|required|min_length[6]|max_length[20]|equals[password]'));
            }

            $validation = new RFormValidationHelper($config);

            if($validation->run())
            {
                $user->name = $_POST['username'];
                foreach($user->columns as $objCol=>$dbCol)
                {
                    if(isset($_POST[$objCol]))
                    {
                        $user->$objCol = $_POST[$objCol];
                    }
                }
                $user->update();
                $this->flash("message","Update information successfully.");

                // if picture selected
                if(isset($_FILES['user_picture'])&&($_FILES['user_picture']['name']!=''))
                {
                    //print_r($_FILES['user_picture']);
                    $upload = new RUploadHelper(array(
                        "file_name"=>"pic_u_".$user->id.RUploadHelper::get_extension($_FILES['user_picture']['name']),
                        "upload_path"=>Rays::getFrameworkPath()."/../public/images/users/"));
                    $upload->upload('user_picture');
                    if($upload->error!='')
                    {
                        $this->flash("error",$upload->error);
                    }
                    else
                    {
                        $user->picture = "public/images/users/".$upload->file_name;
                        $user->update();
                    }
                }
                $this->redirectAction('user','view',$user->id);
                return;
            }
            else
            {
                $errors = $validation->getErrors();
                $data['validation_errors'] = $errors;
                $data['editForm'] = $form;

            }
            /*
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
            */
            //$user->update();
            //$this->flash("message","Update information successfully.");
            //$this->redirectAction('user','view',$user->id);
            //return;
        }
        $this->setHeaderTitle("Edit profile - ".$user->name);
        $this->render('edit',$data,false);
    }
}