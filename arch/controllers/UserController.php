<?php
/**
 * UserController class file.
 * @author: Raysmond
 */

class UserController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "home";
    public $access = array(
        Role::AUTHENTICATED => array('edit', 'logout','home','profile','myPosts', 'applyVIP', 'listFriend'),
        Role::ADMINISTRATOR=>array('admin','processVIP'));

    /**
     * Login action
     */
    public function actionLogin()
    {
        $data = array();
        if (Rays::app()->isUserLogin()) {
            $this->redirectAction('user', 'home');
        }

        if ($this->getHttpRequest()->isPostRequest()) {
            $user = new User();
            $login = $user->login($_POST);
            if ($login == true) {
                $this->getSession()->set("user", $user->id);
                $this->redirectAction('user', 'home');
            } else {
                $data['loginForm'] = $_POST;
                if (isset($login['verify_error'])) {
                    $this->flash('error', $login['verify_error']);
                }
                if (isset($login['validation_errors'])) {
                    $data['validation_errors'] = $login['validation_errors'];
                }
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


    public function actionView($userId, $part = 'joins')
    {
        $user = new User();
        if ($user->load($userId)==null) {
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
            $canAdd = ($friend->uid !== $friend->fid && count($friend->find()) == 0);
            $canCancel = ($friend->uid !== $friend->fid && !$canAdd);
            $canEdit = ($currentUser->id == $user->id);
        }

        $userGroup = [];
        $postTopics = [];
        $likeTopics = [];
        switch ($part) {
            case 'joins': $userGroup = (new GroupUser())->userGroups($userId);break;
            case 'posts': $postTopics = (new Topic())->getUserTopics($userId);break;
            case 'likes': break;//$userGroup = (new GroupUser())->userGroups()
            case 'profile': break;
            default: return;
        }

        $this->setHeaderTitle($user->name);
        $this->render('view',
            array('user' => $user,
                'canEdit' => $canEdit,
                'canAdd' => $canAdd,
                'canCancel' => $canCancel,
                'part' => $part,
                'userGroup' => $userGroup,
                'postTopics' => $postTopics,
                'likeTopics' => $likeTopics,
            ), false);

        // Need to be complete because the codes below will increase the counter every time this page is viewed
        $counter = new Counter();
        $counter->increaseCounter($user->id,User::ENTITY_TYPE);
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
                $user->sendWelcomeMessage();

                /*
                $emailResult = RMailHelper::sendEmail("Welcome to FDUGroup family","<b>Welcome to FDUGroup family</b><br/>-- FDUGroup team <br/>".date('Y-m-d H:i:s'),$_POST['email']);
                if($emailResult!==true){
                    var_dump($emailResult);
                    exit;
                }
                */
                
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

    public function actionMyPosts(){
        $data = array();

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 5;

        $userId = Rays::app()->getLoginUser()->id;
        $posts = new Topic();
        $posts->userId = $userId;
        $count = $posts->count();
        $posts = $posts->find(($curPage-1)*$pageSize,$pageSize,['key'=>$posts->columns['id'],'order'=>'desc']);
        $data['posts'] = $posts;
        $data['count'] = $count;

        $url = RHtmlHelper::siteUrl('user/myposts');
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $data['pager'] = $pager->showPager();

        $this->layout = 'user';
        $this->setHeaderTitle("My posts");
        $this->render('myposts',$data,false);
    }

    public function actionAdmin()
    {
        $this->setHeaderTitle('User administration');
        $this->layout = 'admin';
        $data = array();

        if ($this->getHttpRequest()->isPostRequest()) {
            if (isset($_POST['checked_users'])) {
                $selected = $_POST['checked_users'];
                if (is_array($selected)) {
                    $operation = $_POST['operation_type'];
                    foreach ($selected as $id) {
                        $user = new User();
                        switch ($operation) {
                            case "block":
                                $user->blockUser($id);
                                break;
                            case "active":
                                $user->activeUser($id);
                                break;
                        }
                    }
                }
            }
        }

        $filterStr = $this->getHttpRequest()->getParam('search', null);

        $like = array();
        if ($filterStr != null) {
            $data['filterStr'] = $filterStr;
            if (($str = trim($filterStr)) != '') {
                $names = explode(' ', $str);
                foreach ($names as $val) {
                    array_push($like, array('key' => 'name', 'value' => $val));
                }
            }
        }

        $user = new User();
        $count = $user->count($like);
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page', 1);
        $pageSize = (isset($_GET['pagesize']) && is_numeric($_GET['pagesize'])) ? $_GET['pagesize'] : 10;
        $users = new User();
        $users = $users->find(($curPage - 1) * $pageSize, $pageSize, array('key' => $users->columns["id"], "order" => 'desc'), $like);
        $data['users'] = $users;

        $url = RHtmlHelper::siteUrl('group/admin');
        if ($filterStr != null) $url .= '?search=' . urlencode(trim($filterStr));

        $pager = new RPagerHelper('page', $count, $pageSize, $url, $curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin', $data, false);
    }

    /**
     * User home page
     */
    public function actionHome()
    {
        $this->layout = 'user';
        $user = Rays::app()->getLoginUser();
        $data = array('user' => $user);
        $defaultSize = 5;

        // ajax request
        // load more posts
        if ($this->getHttpRequest()->getIsAjaxRequest()) {
            $topics = new Topic();
            $lastLoadedTime = @$_POST['lastLoadedTime'];
            $lastLoadedTime = $lastLoadedTime != '' ? $lastLoadedTime : null;

            $topics = $topics->getUserFriendsTopics($user->id, $defaultSize,$lastLoadedTime);
            $result = array();
            if(count($topics)>0){
                $result['content'] = $this->renderPartial('posts_list',array('topics'=>$topics),true);
                $result['lastLoadTime'] = $topics[count($topics)-1]['top_created_time'];
                echo json_encode($result);
            }
            else{
                echo json_encode(['content'=>'']);
            }
            exit;
        }

        $topics = new Topic();
        $data['topics'] = $topics->getUserFriendsTopics($user->id, $defaultSize);

        $this->setHeaderTitle($user->name);
        $this->render('home', $data, false);
    }

    /**
     * Apply for VIP
     * by songrenchu
     */
    public function actionApplyVIP() {
        $this->setHeaderTitle('VIP application');

        $this->layout = 'user';
        $user = Rays::app()->getLoginUser();
        $data = array('user'=>$user);

        if ($this->getHttpRequest()->isPostRequest()) {
            $config = [
                ['field' => 'content', 'label' => 'Statement', 'rules' => 'trim|required|min_length[10]|max_length[1000]'],
            ];
            $validation = new RFormValidationHelper($config);

            if ($validation->run()) {
                $censor = new Censor();
                $censor->applyVIPApplication($user->id, RHtmlHelper::encode($_POST['content']));
                $this->flash('message', 'VIP application sent.');
                $this->redirectAction('user', 'profile');
            } else {
                $errors = $validation->getErrors();
                $data['validation_errors'] = $errors;
                $data['editForm'] = $_POST;
                $this->render('apply_vip',$data,false);
            }
            return;
        }

        $censor = new Censor();
        if ($censor->applyVIPExist($user->id)) {
            $this->flash('error', 'Your previous VIP application is under review!');
            $this->redirectAction('user', 'profile');
            return;
        }
        $this->render('apply_vip',$data,false);
    }

    /**
     * Process VIP
     * by songrenchu
     */
    public function actionProcessVIP() {
        $this->setHeaderTitle('Censor VIP');
        $this->layout = 'admin';
        $data = array();

        if (isset($_GET['censorId']) && isset($_GET['op'])) {
            $censor = new Censor();
            if ((int)$_GET['op'] === 0) {
                $censor->passCensor( (int)$_GET['censorId']);

                $user = new User();
                $user->id = $censor->firstId;
                $user->load();
                $user->roleId = Role::VIP_ID;
                $user->update();

                $content = "Congratulations, " . RHtmlHelper::linkAction('user',$user->name,'view',$user->id). "!<br/> Your VIP application is accepted by Administrator.";
                $message = new Message();
                $message->sendMsg("system", 0, $user->id, "VIP application accepted", $content, '');
            } else {
                $censor->failCensor( (int)$_GET['censorId']);

                $user = new User();
                $user->id = $censor->firstId;
                $user->load();
                $content = "Sorry, " . RHtmlHelper::linkAction('user',$user->name,'view',$user->id). "!<br/> Your VIP application is declined by Administrator.";
                $message = new Message();
                $message->sendMsg("system", 0, $user->id, "VIP application declined", $content, '');
            }
            $this->redirectAction('user','processVIP');
        }

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 5;

        $applications = new Censor();
        $applications->status = Censor::UNPROCESS;
        $applications->getTypeIdbyTypeName('apply_vip');
        $count = $applications->count([]);
        $data['count'] = $count;

        $applications = $applications->find(($curPage-1)*$pageSize,$pageSize,array('key'=>$applications->columns["id"],"order"=>'desc'));

        $data['applications'] = $applications;

        $users = [];
        foreach ($applications as $apply) {
            $user = new User();
            $user->id = $apply->firstId;
            $user->load();
            $users[] = $user;
        }

        $data['users'] = $users;

        $url = RHtmlHelper::siteUrl('user/processVIP');

        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('process_vip',$data,false);
    }
}