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
        Role::AUTHENTICATED => array('edit', 'logout','home','profile','myPosts', 'applyVIP', 'listFriend', 'find'),
        Role::ADMINISTRATOR=>array('admin','processVIP'));

    public function actionLogin()
    {
        $data = array();
        if (Rays::isLogin()) {
            $this->redirectAction('user', 'home');
        }

        if (Rays::isPost()) {
            $user = new User();
            $login = $user->login($_POST);
            if ($login === true) {
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

    public function actionLogout()
    {
        $this->getSession()->deleteSession("user");
        $this->flash("message", "You have already logout.");
        $this->redirect(Rays::baseUrl());
    }

    public function actionView($userId, $part = 'joins')
    {
        $user = new User();
        if (!is_numeric($userId) || $user->load($userId) === null || $user->status==User::STATUS_BLOCKED) {
            $this->page404();
            return;
        }
        $data = array('user' => $user, 'part' => $part);
        if (Rays::isLogin()) {
            $friend = new Friend();
            $friend->uid = Rays::user()->id;
            $friend->fid = $user->id;
            $data['canAdd'] = ($friend->uid !== $friend->fid && count($friend->find()) == 0);
            $data['canCancel'] = ($friend->uid !== $friend->fid && !$data['canAdd']);
        }

        switch ($part) {
            case 'joins':
                $data['userGroup'] = GroupUser::userGroups($userId);
                break;
            case 'posts':
                $data['postTopics'] = Topic::getUserTopics($userId);
                break;
            case 'likes':
                $data['likeTopics'] = RatingPlus::getUserPlusTopics($userId);
                break;
            case 'profile':
                break;
            default:
                return;
        }

        $this->setHeaderTitle($user->name);
        $this->render('view', $data, false);

        // Need to be complete because the codes below will increase the counter every time this page is viewed
        $counter = new Counter();
        $counter->increaseCounter($user->id, User::ENTITY_TYPE);
    }

    public function actionProfile($action=null){
        $this->layout = 'user';
        $user = Rays::user();
        if($action==='edit'){
            $this->actionEdit();
            return;
        }
        $this->setHeaderTitle($user->name);
        $this->render('profile',array('user'=>$user),false);
    }


    /**
     * Register action
     */
    public function actionRegister()
    {
        $this->setHeaderTitle("Register");
        $form = '';
        if (Rays::isPost()) {
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
                Rays::import("extensions.phpmailer.*");
                $emailResult = MailHelper::sendEmail("Welcome to FDUGroup family","<b>Welcome to FDUGroup family</b><br/>-- FDUGroup team <br/>".date('Y-m-d H:i:s'),$_POST['email']);
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
        if (!Rays::isLogin()||(isset($userId)) && (!is_numeric($userId))){
            $this->page404();
            return;
        }
        if (isset($userId) && Rays::user()->roleId != Role::ADMINISTRATOR_ID&&Rays::user()->id!=$userId) {
            $this->flash("error", "You don't have the right to change the user information!");
            $this->redirectAction('user', 'view', $userId);
        }
        $user = new User();

        //$user->load(($userId==null)?Rays::user()->id:$userId);
        // for now , the user can only edit his own profile
        $user->load(Rays::user()->id);
        $data = array('user' => $user);
        if (Rays::isPost()) {
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
                        "upload_path" => Rays::app()->getBaseDir() . "/../files/images/users/"));
                    $upload->upload('user_picture');

                    if ($upload->error != '') {
                        $this->flash("error", $upload->error);
                    } else {
                        $user->picture = "files/images/users/" . $upload->file_name;
                        $user->update();
                        RImageHelper::updateStyle($user->picture, User::getPicOptions());
                    }
                }
                $this->redirect($this->getHttpRequest()->getUrlReferrer());
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

    public function actionMyPosts()
    {
        $data = array();

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",10);

        $userId = Rays::user()->id;
        $posts = new Topic();
        $posts->userId = $userId;
        $count = $posts->count();
        $posts = $posts->find(($curPage - 1) * $pageSize, $pageSize, ['key' => $posts->columns['id'], 'order' => 'desc']);
        $data['posts'] = $posts;
        $data['count'] = $count;

        $url = RHtmlHelper::siteUrl('user/myposts');
        $pager = new RPagerHelper('page', $count, $pageSize, $url, $curPage);
        $data['pager'] = $pager->showPager();
        $data['enabledDelete'] = true;

        $this->layout = 'user';
        $this->setHeaderTitle("My posts");
        $this->addCss('/public/css/post.css');
        $this->render('myposts', $data, false);
    }

    public function actionAdmin()
    {
        $this->setHeaderTitle('User administration');
        $this->layout = 'admin';
        $data = array();

        if (Rays::isPost()) {
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

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",10);
        $users = new User();
        $users = $users->find(($curPage - 1) * $pageSize, $pageSize, array('key' => $users->columns["id"], "order" => 'desc'), $like);
        $data['users'] = $users;

        $url = RHtmlHelper::siteUrl('user/admin');
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
        $user = Rays::user();
        $data = array('user' => $user);
        $defaultSize = 10;

        // ajax request
        // load more posts
        if (Rays::isAjax()) {
            $topics = new Topic();
            $lastLoadedTime = @$_POST['lastLoadedTime'];
            $lastLoadedTime = $lastLoadedTime != '' ? $lastLoadedTime : null;

            $topics = $topics->getUserFriendsTopics($user->id, $defaultSize,$lastLoadedTime);
            $result = array();
            if(count($topics)>0){
                $result['content'] = $this->renderPartial('_posts_list',array('topics'=>$topics),true);
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
        $this->addCss('/public/css/post.css');
        $this->render('home', $data, false);
    }

    /**
     * Apply for VIP
     * by songrenchu
     */
    public function actionApplyVIP() {
        $this->setHeaderTitle('VIP application');

        $this->layout = 'user';
        $user = Rays::user();
        $data = array('user'=>$user);

        if (Rays::isPost()) {
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

    public function actionFind() {
        $this->layout = 'user';
        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",24);

        $searchStr = '';
        if (Rays::isPost()) $searchStr = ($_POST['searchstr']);
        else if(isset($_GET['search'])) $searchStr = $_GET['search'];
        $vector = explode(' ', trim($searchStr));
        $like = [];
        foreach ($vector as $value)
            if ($value = trim($value)){
                $like[] = ['key' => 'name', 'value' => $value];
            }
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $userNumber = $user->count($like);
        $user = $user->find(($page - 1)*$pageSize, $pageSize, ['key' => $user->columns['id'], 'order' => 'desc'], $like);

        $data = array('users' => $user);
        if ($searchStr != '') $data['searchstr'] = $searchStr;

        if($searchStr!='')
            $url = RHtmlHelper::siteUrl('user/find?search='.urlencode($searchStr));
        else
            $url = RHtmlHelper::siteUrl('user/find');

        if (count($user)) {
            $pager = new RPagerHelper('page',$userNumber,$pageSize, $url,$page);
            $data['pager'] = $pager->showPager();
        }

        $this->setHeaderTitle("Find User");
        $this->render("find", $data, false);
    }
}