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
        Role::AUTHENTICATED => array('edit', 'logout','home','profile'),
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
        $canCancel = false;
        $currentUser = Rays::app()->getLoginUser();
        if ($currentUser != null) {
            $friend = new Friend();
            $friend->uid = $currentUser->id;
            $friend->fid = $user->id;
            $canAdd = ($friend->uid !== $friend->fid && count($friend->find()) == 0);    //who can add friend: bug fixed by songrenchu
            $canCancel = ($friend->uid !== $friend->fid && !$canAdd);
            $canEdit = ($currentUser->id == $user->id);
        }

        $this->setHeaderTitle($user->name);
        $this->render('view', array('user' => $user, 'canEdit' => $canEdit, 'canAdd' => $canAdd, 'canCancel' => $canCancel), false);
    }

    public function actionProfile($action=null){
        $this->layout = 'user';
        $user = Rays::app()->getLoginUser();
        if($action=='edit'){
            $this->actionEdit();
            return;
        }
        $this->setHeaderTitle($user->name);
        $data = array('user'=>$user);
        $this->render('profile',$data,false);
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
            } else {
                $_POST['password'] = $user->password;
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

        if ($this->getHttpRequest()->isPostRequest()){
            if (isset($_POST['checked_users'])) {
                $selected = $_POST['checked_users'];
                if (is_array($selected)) {
                    $operation = ($_POST['operation_type'] === 'block' ? 0 : 1);
                    foreach ($selected as $block_id) {
                        $user = new User();
                        $user->id = $block_id;
                        $user->load();
                        $user->status = $operation;
                        $user->update();
                    }
                }
            }
        }

        $filterStr = $this->getHttpRequest()->getParam('search',null);

        $like = array();
        if($filterStr!=null){
            $data['filterStr'] = $filterStr;
            if (($str = trim($filterStr))!='') {
                $names = explode(' ', $str);
                foreach ($names as $val) {
                    array_push($like, array('key' => 'name', 'value' => $val));
                }
            }
        }

        $user = new User();
        $count = $user->count($like);
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 10;
        $users = new User();
        $users = $users->find(($curPage-1)*$pageSize,$pageSize,array('key'=>$users->columns["id"],"order"=>'desc'),$like);
        $data['users'] = $users;

        $url = RHtmlHelper::siteUrl('group/admin');
        if($filterStr!=null) $url .= '?search='.urlencode(trim($filterStr));
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('admin',$data,false);
    }

    /**
     * User home page
     */
    public function actionHome(){
        $this->layout = 'user';
        $user = Rays::app()->getLoginUser();
        $data = array('user'=>$user);

        // ajax request
        // load more posts
        if($this->getHttpRequest()->getIsAjaxRequest()){
            $topics = new Topic();
            $lastLoadedTime = @$_POST['lastLoadedTime'];
            $topics = $topics->getUserFriendsTopics($user->id,4,$lastLoadedTime!=''?$lastLoadedTime:null);
            $result = array();
            foreach($topics as $topic){
                $json = array();
                $json['user_name'] = $topic['u_name'];
                $json['user_id'] = $topic['u_id'];
                $json['topic_title'] = $topic['top_title'];
                $json['user_picture'] = RHtmlHelper::siteUrl($topic['u_picture']);
                $json['user_link'] = RHtmlHelper::siteUrl('user/view/'.$topic['u_id']);
                $json['topic_link'] = RHtmlHelper::siteUrl('post/view/'.$topic['top_id']);
                $json['group_name'] = $topic['gro_name'];
                $json['group_id'] = $topic['gro_id'];
                $json['group_link'] = RHtmlHelper::siteUrl('group/detail/'.$topic['gro_id']);
                $json['topic_created_time'] = $topic['top_created_time'];
                $json['topic_reply_count'] = $topic['top_comment_count'];
                $topic['top_content'] = strip_tags(RHtmlHelper::decode($topic['top_content']));
                if (mb_strlen($topic['top_content']) > 140) {
                    $json['topic_content'] =  mb_substr($topic['top_content'], 0, 140,'UTF-8') . '...';
                } else $json['topic_content'] = $topic['top_content'];
                $result[] = $json;

            }

            echo json_encode($result);
            exit;
        }

        $topics = new Topic();
        $topics = $topics->getUserFriendsTopics($user->id,4);

        $data['topics'] = $topics;

        $this->render('home',$data,false);
    }

}