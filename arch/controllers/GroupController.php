<?php
/**
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 上午11:41
 */

class GroupController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "index";
    public $access = array(
        Role::AUTHENTICATED => array('view', 'build', 'edit', 'join', 'accept', 'decline', 'exit','delete','invite', 'acceptInvite'),
        Role::ADMINISTRATOR => array('findAdmin','buildAdmin','admin','recommend'),
    );

    /*
     * Find groups/show all groups
     */
    public function actionFind()
    {
        $page = $this->getHttpRequest()->getQuery('page',1);
        if($page<=0) $page = 1;

        $pageSize = $this->getHttpRequest()->getQuery('pagesize',12);

        $searchStr = '';
        if ($this->getHttpRequest()->isPostRequest()) $searchStr = ($_POST['searchstr']);
        else if(isset($_GET['search'])) $searchStr = $_GET['search'];

        $group = new Group();
        $group->name = trim($searchStr);
        $like = array();
        if (isset($group->name) && $group->name != '') {
            $names = explode(' ', $group->name);
            foreach ($names as $val) {
                array_push($like, array('key' => 'name', 'value' => $val));
            }
            $group = new Group();
        }

        $groups = $group->find(0, 0, array('key'=>'gro_id',"order"=>"desc"), $like);
        $groupSum = count($groups);

        $groups = $group->find($pageSize * ($page - 1), $pageSize, array('key'=>'gro_id',"order"=>"desc"), $like);

        $data = array('group' => $groups);
        if ($searchStr != '') $data['searchstr'] = $searchStr;

        $url = '';
        if($searchStr!='')
            $url = RHtmlHelper::siteUrl('group/find?search='.urlencode($searchStr));
        else
            $url = RHtmlHelper::siteUrl('group/find');

        $pager = new RPagerHelper('page',$groupSum,$pageSize, $url,$page);
        $data['pager'] = $pager->showPager();

        $this->setHeaderTitle("Find Group");
        $this->render("find", $data, false);
    }

    /*
     * View my groups
     */
    public function actionView($userId = null)
    {
        $userGroup = new GroupUser();
        if($userId == null) $userId = Rays::app()->getLoginUser()->id;
        $userGroup = $userGroup->userGroups($userId);
        $this->setHeaderTitle("My Groups");
        $this->render("view", $userGroup, false);
    }

    /**
     * View group detail
     * @param $groupId
     */
    public function actionDetail($groupId)
    {
        if(!is_numeric($groupId)){
            Rays::app()->page404();
            return;
        }

        $group = new Group();
        $result = $group->load($groupId);
        if($result==null){
            Rays::app()->page404();
            return;
        }

        $counter = $group->increaseCounter();
        $group->category->load();
        $group->groupCreator->load();

        $data = array();
        $data['group'] = $group;
        $data['counter'] = $counter->totalCount;

        $posts = new Topic();
        $posts->groupId = $groupId;
        // get latest 20 posts in the group
        $posts = $posts->find(0,20,array('key'=>'top_created_time','value'=>'desc'));
        $data['latestPosts'] = $posts;
        // not good enough
        foreach($posts as $post){
            $post->user = new User();
            $post->user->load($post->userId);
        }
        $data['hasJoined'] = false;
        $data['isManager'] = false;
        if(Rays::app()->isUserLogin()){
            $userId = Rays::app()->getLoginUser()->id;
            // whether the user has joined the group
            $g_u = new GroupUser();
            $g_u->userId = $userId;
            $g_u->groupId = $group->id;
            if(count($g_u->find())>0)
                $data['hasJoined'] = true;

            // whether the login user is the manager of the group
            if($group->creator==$userId)
                $data['isManager'] = true;
        }

        $this->setHeaderTitle($group->name);
        $this->render('detail', $data, false);
    }

    /**
     * Build a new group
     */
    public function actionBuild()
    {
        $this->setHeaderTitle("Build my group");
        $category = new Category();
        $categories = $category->find();
        $data = array('categories' => $categories);
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;
            $rules = array(
                array('field' => 'group-name', 'label' => 'Group name', 'rules' => 'trim|required|min_length[5]|max_length[30]'),
                array('field' => 'category', 'label' => 'Category', 'rules' => 'required'),
                array('field' => 'intro', 'label' => 'Group Introduction', 'rules' => 'trim|required|min_length[10]')
            );
            $user = Rays::app()->getLoginUser();
            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                $group = new Group();
                $group = $group->buildGroup($_POST['group-name'], $_POST['category'], RHtmlHelper::encode($_POST['intro']), $user->id);

                // upload group picture
                $file = $_FILES['group_picture'];
                if (isset($file) && ($file['name'] != '')) {
                    if(($result = $group->uploadPicture('group_picture'))!=true){
                        $this->flash('error',$result);
                    }
                }

                $this->flash("message", "Group was built successfully.");
                $this->redirectAction('group', 'view', $user->id);
            } else {
                // validation failed
                $data['validation_errors'] = $validation->getErrors();
                $data['buildForm'] = $form;
            }
        } else {
            //
        }
        $this->render('build', $data, false);
    }

    /**
     * Edit group information
     * @param $groupId
     */
    public function actionEdit($groupId)
    {
        $this->setHeaderTitle("Edit my group");

        $oldGroup = new Group();
        $oldGroup->load($groupId);

        $category = new Category();
        $categories = $category->find();

        $data = array('categories' => $categories, 'groupId' => $groupId);

        if ($this->getHttpRequest()->isPostRequest()) {
            $rules = array(
                array('field' => 'group-name', 'label' => 'Group name', 'rules' => 'trim|required|min_length[5]|max_length[30]'),
                array('field' => 'category', 'label' => 'Category', 'rules' => 'required'),
                array('field' => 'intro', 'label' => 'Group Introduction', 'rules' => 'trim|required|min_length[10]')
            );

            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                // success
                $group = new Group();
                $group->id = $groupId;
                $group->load();
                $group->name = $_POST['group-name'];
                $group->categoryId = $_POST['category'];
                $group->intro = RHtmlHelper::encode($_POST['intro']);
                $group->update();

                // upload group picture
                $file = $_FILES['group_picture'];
                if (isset($file) && ($file['name'] != '')) {
                    if(($result = $group->uploadPicture('group_picture'))!=true){
                        $this->flash('error',$result);
                    }
                }

                $this->flash("message", "Edit group successfully.");
                $this->redirectAction('group', 'detail', $group->id);
                return;
            } else {
                // validation failed
                $data['editForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        } else {
            $data['oldGroup'] = $oldGroup;
        }
        $this->render('edit', $data, false);
    }


    public function actionJoin($groupId) {  //by songrenchu: need censorship by group creator
        $currentUserId = Rays::app()->getLoginUser()->id;
        $currentUserName = Rays::app()->getLoginUser()->name;

        $group = new Group();
        $group->id = $groupId;
        if ($group->load() !== null) {
            //join group sensor item
            $censor = new Censor();
            $censor = $censor->joinGroupApplication($currentUserId, $group->id);

            $content = RHtmlHelper::linkAction('user',$currentUserName,'view',$currentUserId)." wants to join your group ".
                RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id)
                ."<br/>" .
                RHtmlHelper::link("Accept", "Accept", Rays::app()->getBaseUrl() . "/group/accept/{$censor->id}",array('class'=>'btn btn-xs btn-success'))."&nbsp;&nbsp;".
                RHtmlHelper::link("Decline", "Decline", Rays::app()->getBaseUrl() . "/group/decline/{$censor->id}",array('class'=>'btn btn-xs btn-danger'));

            $message = new Message();
            $message->sendMsg("group", $groupId, $group->creator, "Join group request", $content, '');

            $this->flash('message', 'Joining group request has been sent.');
        }
        if(isset($_GET['returnurl']))
            $this->redirect($_GET['returnurl']);
        else
            $this->redirectAction('group','find');
    }

    public function actionAcceptInvite($censorId = null) {
        $censor = new Censor();
        $censor->id = (int)$censorId;
        if ($censor->load() !== null) {
            if ($censor->firstId == Rays::app()->getLoginUser()->id) {
                $groupUser = new GroupUser();
                $groupUser->groupId = $censor->secondId;
                $groupUser->userId = $censor->firstId;
                $groupUser->joinTime = date('Y-m-d H:i:s');
                $groupUser->status = 1;

                $gu = new GroupUser();
                if(!$gu->isUserInGroup($groupUser->userId,$groupUser->groupId)){
                    $groupUser->insert();
                    $group = new Group();
                    $group->load($groupUser->groupId);
                    $group->memberCount++;
                    $group->update();
                    $this->flash("message", "Join group successfully.");
                }else{
                    $this->flash("warning","You're already a member of this group.");
                }
                $censor->passCensor($censorId);
            }
            $this->redirectAction('message','view');
        }
    }

    public function actionAccept($censorId = null)
    {
        $censor = new Censor();
        $censor->id = (int)$censorId;
        if ($censor->load() !==null) {
            $groupUser = new GroupUser();
            $groupUser->groupId = $censor->secondId;
            $groupUser->userId = $censor->firstId;
            $groupUser->joinTime = date('Y-m-d H:i:s');
            $groupUser->status = 1;

            $gu = new GroupUser();
            if(!$gu->isUserInGroup($groupUser->userId,$groupUser->groupId)){
                $groupUser->insert();
                $group = new Group();
                $group->load($groupUser->groupId);
                $group->memberCount++;
                $group->update();

                $this->flash("message", "The request is processed.");

                $title = "Join group request accepted";
                $content = 'Group creator has accepted your request of joining in group ' . RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
                $content = RHtmlHelper::encode($content);
                $message = new Message();
                $message->sendMsg("group", $group->id, $groupUser->userId, $title, $content);

            }else{
                $this->flash("warning","You're already a member of this group.");
            }

            $censor->passCensor($censorId);
            $this->redirectAction('message','view');
        }
    }

    public function actionDecline($censorId = null) {
        $censor = new Censor();
        $censor->id = $censorId;
        if ($censor->load() !==null) {
            $groupUser = new GroupUser();
            $groupUser->groupId = $censor->secondId;
            $groupUser->userId = $censor->firstId;
            $groupUser->joinTime = date('Y-m-d H:i:s');
            $groupUser->status = 1;

            $gu = new GroupUser();
            if(!$gu->isUserInGroup($groupUser->userId,$groupUser->groupId)){
                $this->flash("message", "The request is processed.");
                $group = new Group();
                $group->load($groupUser->groupId);

                $title = "Join group request accepted";
                $content = 'Group creator have declined your request of joining in group ' . RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
                $content = RHtmlHelper::encode($content);
                $message = new Message();
                $message->sendMsg("group", $group->id, $groupUser->userId, $title, $content);
            }else{
                $this->flash("warning","TA is already a member of this group.");
            }

            $censor->failCensor($censorId);
            $this->redirectAction('message','view');
        }
    }

    public function actionExit($groupId = null)
    {

        $groupUser = new GroupUser();
        $groupUser->groupId = $groupId;
        $groupUser->userId = Rays::app()->getLoginUser()->id;

        $group = new Group();
        $group->load($groupId);

        // group creator cannot exit the group
        if($group->creator==$groupUser->userId){
            $this->flash("error", "You cannot exit group ".RHtmlHelper::linkAction('group',$group->name,'detail',$group->id)." , because you're the group creator!");
        }
        else{
            $group->memberCount--;
            $group->update();
            $groupUser->delete();
            $this->flash("message", "You have exited the group successfully.");
        }

        $this->redirectAction('group', 'view', Rays::app()->getLoginUser()->id);

    }

    /* ------------------------------------------------------------------------- */
    /* Group administration */
    /* ------------------------------------------------------------------------- */

    public function actionFindAdmin($page = 1, $search = '', $pagesize = 3)
    {
        $this->layout = 'admin';
        $this->actionFind($page,$search,$pagesize);
    }

    public function actionBuildAdmin()
    {
        $this->layout = 'admin';
        $this->actionBuild();
    }

    /**
     * Delete group
     * This action will delete all content related to the group, including topics, comments
     * that belong the group
     * @access group creator | administrator
     * @param $groupId
     */
    public function actionDelete($groupId)
    {
        if (isset($groupId) && $groupId != '' && is_numeric($groupId)) {
            $group = new Group();
            $group->load($groupId);
            if (isset($group->id) && $group->id != '') {
                $userId = Rays::app()->getLoginUser()->id;
                if ($group->creator == $userId) {

                    // Execute delete group transaction
                    $group->deleteGroup();

                    // Delete group's picture from local file system
                    if (isset($group->picture) && $group->picture != '') {
                        $picture = Rays::getFrameworkPath() . "/../" . $group->picture;
                        if (file_exists($picture))
                            unlink($picture);
                    }
                    $this->flash("message", "Group " . $group->name . " was deleted.");
                    $this->redirectAction("group", "view");
                } else {
                    $this->flash("error", "Sorry. You don't have the right to delete the group!");
                    $this->redirectAction('group', 'detail', $group->id);
                }
            } else {
                $this->flash("error", "No such group.");
                Rays::app()->page404();
                return;
            }
        } else {
            $this->flash("error", "No such group.");
            Rays::app()->page404();
            return;
        }
    }

    public function actionAdmin(){
        $this->setHeaderTitle('Group administration');
        $this->layout = 'admin';
        $data = array();

        if($this->getHttpRequest()->isPostRequest()){
            if(isset($_POST['checked_groups'])){
                $groups = $_POST['checked_groups'];
                foreach($groups as $group){
                    if(!is_numeric($group)) break;
                    $groupObj = new Group();
                    $groupObj->id = $group;
                    $groupObj->deleteGroup();
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

        $rows = new Group();
        $count = $rows->count($like);
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 4;
        $groups = new Group();
        $data['groups'] = $groups->findAll(($curPage-1)*$pageSize,$pageSize,array('key'=>'id',"order"=>'desc'),array(),$like);;

        $url = RHtmlHelper::siteUrl('group/admin');
        if($filterStr!=null) $url .= '?search='.urlencode(trim($filterStr));

        // pager
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin',$data,false);
    }

    public function actionInvite($groupId){
        if(!isset($groupId)||!is_numeric($groupId)){
            Rays::app()->page404();
            return;
        }

        $group = new Group();
        $result = $group->load($groupId);
        if($result==null){
            Rays::app()->page404();
            return;
        }

        $data = array();
        $data['group'] = $group;

        $user = Rays::app()->getLoginUser();
        $friends = new Friend();
        $friends = $friends->getFriendsToInvite($user->id, $groupId);
        $data['friends'] = $friends;

        if ($this->getHttpRequest()->isPostRequest()) {
            if (isset($_POST['select_friends'])) {
                Group::inviteFriends($groupId,$user,$_POST['select_friends'],$_POST['invitation']);
                $this->flash('message', 'Send invitation successfully.');
            } else {
                $this->flash('warning', 'No invitation was send!');
            }
        }

        $this->render('invite', $data, false);
    }

    /**
     * Recommend groups to users
     * @access: administrator
     */
    public function actionRecommend()
    {
        if ($this->getHttpRequest()->getIsAjaxRequest()) {
            $action = $this->getHttpRequest()->getParam('action', null);
            if ($action) {
                $name = $this->getHttpRequest()->getParam('name', null);
                $like = array();
                if (isset($name) && $name != '') {
                    $names = explode(' ', $name);
                    foreach ($names as $val) {
                        array_push($like, array('key' => 'name', 'value' => $val));
                    }
                }
                switch ($action) {
                    case "search_groups":
                        $group = new Group();
                        $groups = $group->find(0, 0, array(), $like);
                        $results = array();
                        foreach($groups as $item){
                            $result['id'] = $item->id;
                            $result['name'] = $item->name;
                            $result['link'] = RHtmlHelper::siteUrl('group/detail/'.$item->id);
                            $result['picture'] = $item->picture;
                            $results[] = $result;
                        }
                        echo json_encode($results);
                        exit;
                        break;
                    case "search_users":
                        $user = new User();
                        $users = $user->find(0, 0, array(), $like);
                        $results = array();
                        foreach($users as $item){
                            $result['id'] = $item->id;
                            $result['name'] = $item->name;
                            $result['link'] = RHtmlHelper::siteUrl('user/view/'.$item->id);
                            $result['picture'] = $item->picture;
                            $results[] = $result;
                        }
                        echo json_encode($results);
                        exit;
                        break;
                    default:
                }
            }
        }

        if ($this->getHttpRequest()->isPostRequest()) {
            if (isset($_POST['selected_recommend_groups']) && isset($_POST['selected_recommend_users'])) {
                $groups = $_POST['selected_recommend_groups'];
                $users = $_POST['selected_recommend_users'];
                $words = $_POST['recommend-words'];
                Group::recommendGroups($groups,$users,$words);
                $this->flash('message','Send group recommendations successfully.');
            }
        }

        $this->layout = 'admin';
        $data = array();
        $this->setHeaderTitle("Groups recommendation");
        $this->render('recommend',$data,false);
    }

}