<?php
/**
 * GroupController class
 *
 * @author: Junshi Guo, Raysmond, Renchu Song
 */

class GroupController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "index";
    public $access = array(
        Role::AUTHENTICATED => array('myGroups', 'build', 'edit', 'join', 'accept', 'decline', 'exit','delete','invite', 'acceptInvite'),
        Role::ADMINISTRATOR => array('findAdmin','buildAdmin','admin','recommend'),
    );

    public $_group;

    public function filteredGroup(){
        return isset($this->_group)?$this->_group : null;
    }

    public function beforeAction($action){
        $params = $this->getActionParams();
        $result = true;
        switch($action){
            case "detail":
            case "edit":
            case "members":
            case "exit":
            case "delete":
            case "invite":
                $group = new Group();
                $result = false;
                if(isset($params[0]) && is_numeric($params[0]) && $group->load($params[0]) !== null){
                    $this->_group = $group;
                    $result = true;
                }
                break;
        }
        if(!$result){
            $this->page404();
            return false;
        }
        return true;
    }

    /*
     * Find groups/show all groups
     */
    public function actionFind()
    {
        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",5);
        $searchStr = Rays::getParam("searchstr",'');

        $like = array();
        if ($name = trim($searchStr)) {
            $names = preg_split("/[\s]+/", $name);
            foreach ($names as $val)
                array_push($like, array('key' => 'name', 'value' => $val));
        }

        $group = new Group();
        $groups = $group->find($pageSize * ($page - 1), $pageSize, ['key'=>$group->columns['id'],"order"=>"desc"], $like);

        if(Rays::isAjax()){
            echo empty($groups)? 'nomore': $this->renderPartial("_groups_list", ["groups"=>$groups], true);
            exit;
        }

        $this->setHeaderTitle("Find Group");

        $this->addJs("/public/js/masonry.pkgd.min.js");
        $this->addCss("/public/css/group.css");
        $this->render("find", ['groups'=>$groups, 'searchstr'=>$searchStr], false);
    }

    /*
     * View my groups
     */
    public function actionMyGroups()
    {
        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",5);
        $groups = GroupUser::userGroups(Rays::user()->id, ($page - 1) * $pageSize, $pageSize);

        if(Rays::isAjax()){
            echo empty($groups)? 'nomore' : $this->renderPartial("_groups_list", ["groups"=>$groups, 'exitGroup' => true],true);
            exit;
        }

        $this->layout = 'user';
        $this->addCss('/public/css/group.css');
        $this->addJs('/public/js/masonry.pkgd.min.js');
        $this->setHeaderTitle("My Groups");
        $this->render("my_groups", ['groups' => $groups, 'exitGroup' => true], false);
    }

    /**
     * View group detail
     * @param $groupId
     */
    public function actionDetail($groupId)
    {
        // group loaded in beforeAction() method
        $group = $this->filteredGroup();
        $group->category->load();
        $group->groupCreator->load();

        $counter = $group->increaseCounter();

        $posts = new Topic();
        $posts->groupId = $groupId;
        // get latest 20 posts in the group
        $posts = $posts->find(0,20,array('key'=>'top_created_time','value'=>'desc'));

        // not good enough
        foreach($posts as $post){
            $post->user = new User();
            $post->user->load($post->userId);
        }

        $data = ['group'=>$group, 'counter'=>$counter->totalCount, 'latestPosts'=>$posts];

        $isLogin = Rays::isLogin();
        $data['hasJoined'] = $isLogin && GroupUser::isUserInGroup(Rays::user()->id,$group->id);
        $data['isManager'] = $isLogin && $group->creator==Rays::user()->id;

        $this->setHeaderTitle($group->name);
        $this->addCss("/public/css/post.css");
        $this->render('detail', $data, false);
    }

    /**
     * Create a new group
     */
    public function actionBuild()
    {
        $this->layout = 'user';
        $this->setHeaderTitle("Build my group");

        $data = array('categories' => (new Category())->find());

        if (Rays::isPost()) {
            $form = $_POST;
            $rules = array(
                array('field' => 'group-name', 'label' => 'Group name', 'rules' => 'trim|required|min_length[5]|max_length[50]'),
                array('field' => 'category', 'label' => 'Category', 'rules' => 'required'),
                array('field' => 'intro', 'label' => 'Group Introduction', 'rules' => 'trim|required|min_length[10]')
            );
            $user = Rays::user();
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
        // group loaded in beforeAction() method
        $oldGroup = $this->filteredGroup();

        $category = new Category();
        $categories = $category->find();

        $data = array('categories' => $categories, 'groupId' => $groupId);

        if (Rays::isPost()) {
            $rules = array(
                array('field' => 'group-name', 'label' => 'Group name', 'rules' => 'trim|required|min_length[5]|max_length[50]'),
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
        $this->setHeaderTitle("Edit my group");
        $this->render('edit', $data, false);
    }

    /**
     * Show all group members
     * @param $groupId
     * @return mixed
     */
    public function actionMembers($groupId)
    {
        return $this->dispatchAction('members','controllers.groups.MembersAction');
    }


    public function actionJoin($groupId) {  //by songrenchu: need censorship by group creator
        $userId = Rays::user()->id;
        $userName = Rays::user()->name;

        $joinRequest = false;
        $text = '';
        $group = new Group();
        if (is_numeric($groupId) && $group->load($groupId) !== null) {
            //join group sensor item
            $censor = new Censor();
            $censor = $censor->joinGroupApplication($userId, $group->id);

            $content = RHtmlHelper::linkAction('user',$userName,'view',$userId)." wants to join your group ".
                RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id)
                ."<br/>"
                .RHtmlHelper::linkAction('group','Accept','accept', $censor->id,array('class'=>'btn btn-xs btn-success'))
                ."&nbsp;&nbsp;"
                .RHtmlHelper::linkAction('group','Decline','decline', $censor->id,array('class'=>'btn btn-xs btn-danger'));

            $message = new Message();
            $message->sendMsg("group", $groupId, $group->creator, "Join group request", $content, '');

            $joinRequest = true;
            $text = 'Your join-group request has been send to the group manager!';
        }
        else{
            $text = 'Group does not exist!';
        }

        if(Rays::isAjax()){
            echo json_encode(['result'=>$joinRequest,'text'=>$text]);
            exit;
        }
        else{
            $this->flash(($joinRequest?"message":"warning"),$text);
            $this->redirect(Rays::referrerUri());
        }
    }

    public function actionAcceptInvite($censorId = null) {
        $censor = new Censor();
        $censor->id = (int)$censorId;
        if ($censor->load() !== null) {
            if ($censor->firstId == Rays::user()->id) {
                $groupUser = new GroupUser();
                $groupUser->groupId = $censor->secondId;
                $groupUser->userId = $censor->firstId;
                $groupUser->joinTime = date('Y-m-d H:i:s');
                $groupUser->status = 1;

                if(!GroupUser::isUserInGroup($groupUser->userId,$groupUser->groupId)){
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

            if(!GroupUser::isUserInGroup($groupUser->userId,$groupUser->groupId)){
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

            if(!GroupUser::isUserInGroup($groupUser->userId,$groupUser->groupId)){
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
        $groupUser->userId = Rays::user()->id;

        // group loaded in beforeAction() method
        $group = $this->filteredGroup();

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

        $this->redirectAction('group', 'view', Rays::user()->id);

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
        // group loaded in beforeAction() method
        $group = $this->filteredGroup();

        $userId = Rays::user()->id;
        if ($group->creator == $userId) {

            // Execute delete group transaction
            $group->deleteGroup();

            // Delete group's picture from local file system
            if (isset($group->picture) && $group->picture != '') {
                $picture = Rays::app()->getBaseDir() . "/../" . $group->picture;
                if (file_exists($picture))
                    unlink($picture);
            }
            $this->flash("message", "Group " . $group->name . " was deleted.");
            $this->redirectAction("group", "view");
        } else {
            $this->flash("error", "Sorry. You don't have the right to delete the group!");
            $this->redirectAction('group', 'detail', $group->id);
        }
    }

    /**
     * Groups administration
     */
    public function actionAdmin(){
        $this->setHeaderTitle('Group administration');
        $this->layout = 'admin';
        $data = array();

        if(Rays::isPost()){
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

        $filterStr = Rays::getParam('search',null);

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

        $curPage = $this->getPage("page");
        $size = $this->getPageSize("pagesize",5);
        $groups = new Group();
        $data['groups'] = $groups->findAll(($curPage-1)*$size,$size,array('key'=>'id',"order"=>'desc'),array(),$like);;

        $url = RHtmlHelper::siteUrl('group/admin');
        if($filterStr!=null) $url .= '?search='.urlencode(trim($filterStr));

        // pager
        $pager = new RPagerHelper('page',$count,$size,$url,$curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin',$data,false);
    }

    public function actionInvite($groupId){
        // group loaded in beforeAction() method
        $group = $this->filteredGroup();

        $data = array();
        $data['group'] = $group;

        $user = Rays::user();
        $friends = new Friend();
        $friends = $friends->getFriendsToInvite($user->id, $groupId);
        $data['friends'] = $friends;

        if (Rays::isPost()) {
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
        if (Rays::isAjax()) {
            $action = Rays::getParam('action', null);
            if ($action) {
                $name = Rays::getParam('name', null);
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

        if (Rays::isPost()) {
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