<?php
/**
 * UserController class file.
 *
 * @author: Raysmond
 */

class UserController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "home";
    public $access = array(
        Role::AUTHENTICATED => array('edit', 'logout','home','profile','myPosts', 'applyVIP', 'listFriend', 'find'),
        Role::ADMINISTRATOR=>array('admin','processVIP'));

    private $loginRedirect = ['group', 'post']; //允许重定向的范围。目前仅支持Controller级别。将来可以扩展为键值对精确到action

    public function actionLogin()
    {
        if (Rays::isLogin()) {
            $this->redirectAction('user', 'home');
        }

        $this->layout = 'user_ui';
        $data = array();

        if (Rays::isPost()) {
            $user = new User();
            $login = User::login($_POST);
            if ($login instanceof User) {
                $this->getSession()->set("user", $login->id);
                if (!isset($_POST['returnURL'])) {
                    $this->redirect(RHtmlHelper::siteUrl("user/home"));
                }

                var_dump(Rays::router()->splitControllerAction($_POST['returnURL']));exit;
                if (!in_array(Rays::router()->splitControllerAction($_POST['returnURL']), $this->loginRedirect)) {
                    $this->redirect(RHtmlHelper::siteUrl("user/home"));
                }
                $this->redirect($_POST['returnURL']);
            } else {
                $data['loginForm'] = $_POST;
                if (isset($login['verify_error'])) {
                    $this->flash('error', $login['verify_error']);
                }
                $data['validation_errors'] = isset($login['validation_errors'])?$login['validation_errors']:null;
                }
        }
        $this->setHeaderTitle("Login");
        $this->addCss('/public/css/form.css');
        $this->render('login', $data, false);
    }

    public function actionLogout()
    {
        $this->getSession()->deleteSession("user");
        $this->redirect(Rays::baseUrl());
    }

    public function actionView($userId, $part = 'joins')
    {
        $user = User::get($userId);
        RAssert::not_null($user);

        $data = array('user' => $user, 'part' => $part);
        if (Rays::isLogin()) {
            $currentUser = Rays::user();
            $friend = new Friend();
            $friend->uid = Rays::user()->id;
            $friend->fid = $user->id;
            $data['canAdd'] = ($currentUser->id !== $user->id && Friend::find(array("uid", $currentUser->id, "fid", $user->id))->first() == null);
            $data['canCancel'] = ($currentUser->id !== $user->id && !$data['canAdd']);
        }
        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pageSize",10);
        $count = 0;
        switch ($part) {
            case 'joins':
                $pageSize = $this->getPageSize("pageSize",5);
                $data['userGroup'] = GroupUser::getGroups(GroupUser::find("userId", $userId)->join("group")->order_desc("groupId")->range(($page-1) * $pageSize, $pageSize));
                $count = User::countGroups($userId);
                break;
            case 'posts':
                $data['postTopics'] = Topic::find("userId",$userId)->join("group")->order_desc("id")->range(($page-1) * $pageSize, $pageSize);
                $count = User::countPosts($userId);
                break;
            case 'likes':
                $data['likeTopics'] = RatingPlus::getUserPlusTopics($userId, ($page-1) * $pageSize, $pageSize);
                $count = RatingPlus::countUserPostsPlus($userId);
                break;
            case 'profile':
                break;
            default:
                return;
        }

        if(Rays::isAjax()){
            echo empty($data['userGroup'])? 'nomore' : $this->renderPartial("_common._groups_list", ["groups"=>$data['userGroup']],true);
            exit;
        }

        if($part=="posts" || $part=="likes"){
            if($count>$pageSize){
                $pager = new RPagerHelper("page",$count,$pageSize,RHtmlHelper::siteUrl("user/view/".$userId."/".$part),$page);
                $data['pager'] = $pager->showPager();
            }
        }

        if($part=="joins"){
            $this->addCss('/public/css/group.css');
            $this->addJs('/public/js/masonry.pkgd.min.js');
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
            $this->actionEdit($user->id);
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
        if(Rays::isLogin()){
            $this->actionHome();
            return;
        }
        $this->layout = 'user_ui';
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
                $user = User::register($_POST['username'], md5($_POST['password']), $_POST['email']);
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
    public function actionEdit($userId=null)
    {
        $userId = (null===$userId)?Rays::user()->id: $userId;
        $user = User::get($userId);
        RAssert::not_null($user);

        if (Rays::user()->roleId != Role::ADMINISTRATOR_ID && Rays::user()->id!=$userId) {
            $this->flash("error", "You don't have the right to change the user information!");
            $this->redirectAction('user', 'view', $userId);
        }

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
                foreach (User::$mapping as $objCol => $dbCol) {
                    if (isset($_POST[$objCol])) {
                        $user->$objCol = $_POST[$objCol];
                    }
                }
                $user->save();
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
                        $user->save();
                        RImageHelper::updateStyle($user->picture, User::getPicOptions());
                    }
                }
                $this->redirect(Rays::referrerUri());
                return;
            } else {
                $errors = $validation->getErrors();
                $data['validation_errors'] = $errors;
                $data['editForm'] = $_POST;

            }
        }

        $this->layout = 'user';
        $this->setHeaderTitle("Edit profile - " . $user->name);
        $this->render('edit', $data, false);
    }

    public function actionMyPosts()
    {
        $data = array();

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",10);

        $userId = Rays::user()->id;
        $query = Topic::find("userId", $userId);
        $count = $query->count();
        $posts = $query->order_desc("id")->range(($curPage - 1) * $pageSize, $pageSize);
        $data['posts'] = $posts;
        $data['count'] = $count;

        $url = RHtmlHelper::siteUrl('user/myposts');
        $pager = new RPagerHelper('page', $count, $pageSize, $url, $curPage);
        $data['pager'] = ($count>$curPage*$pageSize)?$pager->showPager() : null;
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
                        switch ($operation) {
                            case "block":
                                User::blockUser($id);
                                break;
                            case "active":
                                User::activateUser($id);
                                break;
                        }
                    }
                }
            }
        }


        $searchStr = Rays::getParam('search', null);

        $query = User::find();
        if ($name = trim($searchStr)) {
            $names = preg_split("/[\s]+/", $name);
            foreach ($names as $key) {
                $query = $query->like("name", $key);
            }
        }
        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize", 10);

        $count = $query->count();
        $users = $query->order_desc("id")->order_desc("id")->range($pageSize * ($page - 1), $pageSize);
        $data['count'] = $count;
        $data['users'] = $users;

        $url = RHtmlHelper::siteUrl('user/admin');
        if ($searchStr != null) $url .= '?search=' . urlencode(trim($searchStr));

        $pager = new RPagerHelper('page', $count, $pageSize, $url, $page);
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
        if ($censor->applyVIPExist($user->id)!=null) {
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
            $censor = Censor::get($_GET['censorId']);
            if($censor!==null){
                if ((int)$_GET['op'] === 0) {
                    $user = User::get($censor->firstId);
                    $user->roleId = Role::VIP_ID;
                    $user->save();

                    $censor->pass();

                    $content = "Congratulations, " . RHtmlHelper::linkAction('user',$user->name,'view',$user->id). "!<br/> Your VIP application is accepted by Administrator.";
                    Message::sendMessage("system", 0, $user->id, "VIP application accepted", RHtmlHelper::encode($content), '');
                } else {
                    $censor->fail();

                    $user = User::get($censor->firstId);
                    $content = "Sorry, " . RHtmlHelper::linkAction('user',$user->name,'view',$user->id). "!<br/> Your VIP application is declined by Administrator.";
                    Message::sendMessage("system", 0, $user->id, "VIP application declined", RHtmlHelper::encode($content), '');
                }
            }
            $this->redirectAction('user','processVIP');
        }

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",5);

        $query = Censor::find(['status',Censor::UNPROCESS,'typeId',(new Censor())->getTypeId("apply_vip")]);
        $count = $data['count'] = $query->count();

        $applications = $query->order_desc("id")->range(($curPage-1)*$pageSize,$pageSize);

        $data['applications'] = $applications;

        $users = [];
        foreach ($applications as $apply) {
            $user = User::get($apply->firstId);
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

        $query = User::find();
        if ($name = trim($searchStr)) {
            $names = preg_split("/[\s]+/", $name);
            foreach ($names as $key) {
                $query = $query->like("name", $key);
            }
        }

        $count = $query->count();
        $users = $query->range(($page-1)*$pageSize,$pageSize);

        $url = RHtmlHelper::siteUrl('user/find'.($searchStr!='')?'?search='.urlencode($searchStr):"");
        $pager = new RPagerHelper('page',$count,$pageSize, $url,$page);

        $this->setHeaderTitle("Find User");
        $this->render("find", ['users' => $users,'searchstr'=>$searchStr,'pager'=>$pager->showPager()], false);
    }
}