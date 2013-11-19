<?php
/**
 * UserController class file.
 * @author: Raysmond
 */

class UserController extends RController
{
    public $layout = "index";
    public $defaultAction = "index";
    public $access = array(
        Role::AUTHENTICATED => array('edit', 'logout','home'),
        Role::ADMINISTRATOR=>array('admin'));

    /**
     * Login action
     */
    public function actionLogin()
    {
        $data = array();
        if (Rays::app()->isUserLogin()) {
            $this->flash("message", Rays::app()->getLoginUser()->name . ", you have already login...");
            $this->redirect(Rays::app()->getBaseUrl());
            return;
        }

        if ($this->getHttpRequest()->isPostRequest()) {

            $validation = new RFormValidationHelper(array(
                array('field' => 'username', 'label' => 'User name', 'rules' => 'trim|required'),
                array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required')
            ));

            if ($validation->run()) {
                $user = new User();
                $login = $user->verifyLogin($_POST['username'], $_POST['password']);
                if ($login instanceof User) {
                    $this->getSession()->set("user", $login->id);
                    $this->flash("message", "Login successfully.");
                    $this->redirect(Rays::app()->getBaseUrl());
                    return;
                } else {
                    $this->flash("error", $login);
                    $data['loginForm'] = $_POST;
                }
            } else {
                $data['validation_errors'] = $validation->getErrors();
                $data['loginForm'] = $_POST;
            }
        }
        $this->setHeaderTitle("Login");
        $this->addCss('/public/css/form.css');
        $this->render('login', $data, false);
    }

    /**
     * Logout action
     */
    public function actionLogout()
    {
        $this->getSession()->deleteSession("user");
        $this->flash("message", "You have already logout.");
        $this->redirect(Rays::app()->getBaseUrl());
    }

    /**
     * View user profile
     * @param $userId
     */
    public function actionView($userId)
    {
        $user = new User();
        $user->load($userId);
        if (!isset($user->id)) { // no such user
            Rays::app()->page404();
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

    /**
     * Register action
     */
    public function actionRegister()
    {
        $this->setHeaderTitle("Register");
        $form = '';
        if ($this->getHttpRequest()->isPostRequest()) {
            // validate the form data
            $rules = array(
                array('field' => 'username', 'label' => 'User name', 'rules' => 'trim|required|min_length[5]|max_length[20]'),
                array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'),
                array('field' => 'password-confirm', 'label' => 'Password Confirm', 'rules' => 'trim|required|equals[password]'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|is_email')
            );
            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                $user = new User();
                $user->register($_POST['username'], md5($_POST['password']), $_POST['email']);
                $message = new Message();
                $message->sendMsg('system', 0, $user->id, "Welcome, " . $user->name,
                    RHtmlHelper::encode("Dear " . $user->name . " : <br/>Welcome to join the FDUGroup bit family!<br/><br/>--- FDUGroup team<br/>"), null, 1);

                $this->flash("message", "Hello," . $user->name . ", please " . RHtmlHelper::linkAction('user', 'login', 'login') . " !");
                $this->redirectAction('user', 'view', $user->id);
            } else {
                $this->render('register',
                    array('validation_errors' => $validation->getErrors(), 'registerForm' => $_POST), false);
            }
        } else $this->render('register', null, false);
    }


    /**
     * Change user info action
     * @param null $userId
     */
    public function actionEdit($userId = null)
    {
        if (!Rays::app()->isUserLogin()||(isset($userId)) && (!is_numeric($userId))){
            Rays::app()->page404();
            return;
        }
        if (isset($userId) && Rays::app()->getLoginUser()->roleId != Role::ADMINISTRATOR_ID&&Rays::app()->getLoginUser()->id!=$userId) {
            $this->flash("error", "You don't have the right to change the user information!");
            $this->redirectAction('user', 'view', $userId);
        }
        $user = new User();

        //$user->load(($userId==null)?Rays::app()->getLoginUser()->id:$userId);
        // for now , the user can only edit his own profile
        $user->load(Rays::app()->getLoginUser()->id);
        $data = array('user' => $user);
        if ($this->getHttpRequest()->isPostRequest()) {
            $config = array(
                array('field' => 'username', 'label' => 'User name', 'rules' => 'trim|required|min_length[5]|max_length[20]'),
            );
            // if set password, then go changing password
            if (isset($_POST['password']) && ($_POST['password'] != '')) {
                array_push($config, array('field' => 'password', 'label' => 'New Password', 'rules' => 'trim|required|min_length[6]|max_length[20]'));
                array_push($config, array('field' => 'password-confirm', 'label' => 'New Password Confirm', 'rules' => 'trim|required|min_length[6]|max_length[20]|equals[password]'));
            }

            $validation = new RFormValidationHelper($config);

            if ($validation->run()) {
                $user->name = $_POST['username'];
                foreach ($user->columns as $objCol => $dbCol) {
                    if (isset($_POST[$objCol])) {
                        $user->$objCol = $_POST[$objCol];
                    }
                }
                $user->update();
                $this->flash("message", "Update information successfully.");

                // if picture selected
                if (isset($_FILES['user_picture']) && ($_FILES['user_picture']['name'] != '')) {
                    //print_r($_FILES['user_picture']);
                    $upload = new RUploadHelper(array(
                        "file_name" => "pic_u_" . $user->id . RUploadHelper::get_extension($_FILES['user_picture']['name']),
                        "upload_path" => Rays::getFrameworkPath() . "/../public/images/users/"));
                    $upload->upload('user_picture');

                    if ($upload->error != '') {
                        $this->flash("error", $upload->error);
                    } else {
                        $user->picture = "public/images/users/" . $upload->file_name;
                        $user->update();
                    }
                }
                $this->redirectAction('user', 'view', $user->id);
                return;
            } else {
                $errors = $validation->getErrors();
                $data['validation_errors'] = $errors;
                $data['editForm'] = $_POST;

            }
        }
        $this->setHeaderTitle("Edit profile - " . $user->name);
        $this->render('edit', $data, false);
    }

    public function actionAdmin(){
        $this->setHeaderTitle('User administration');
        $this->layout = 'admin';
        $data = array();

        $user = new User();
        $count = $user->count();
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = 10;
        $users = new User();
        $users = $users->find(($curPage-1)*$pageSize,$pageSize,array('key'=>$users->columns["id"],"order"=>'desc'));
        $data['users'] = $users;

        $pager = new RPagerHelper('page',$count,$pageSize,RHtmlHelper::siteUrl('user/admin'),$curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('admin',$data,false);
    }

    public function actionHome(){
        $user = Rays::app()->getLoginUser();
        $data = array('user'=>$user);

        $friends = new Friend();
        $friends->uid = $user->id;
        $friends = $friends->find();

        $topics = new Topic();
        $ids = array();
        foreach($friends as $friend){
            $ids[] = $friend->fid;
        }
        $topics = $topics->find(0,10,array('key'=>'top_id','order'=>'desc'),array(),array('userId'=>$ids));
        foreach($topics as $topic){
            $topic->user = new User();
            $topic->user->load($topic->userId);
        }

        $data['topics'] = $topics;

        $this->render('home',$data,false);
    }
}