<?php
/**
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 上午11:41
 */

class GroupController extends RController
{
    public $layout = "index";
    public $defaultAction = "index";
    public $access = array(
        Role::AUTHENTICATED => array('view', 'build', 'edit', 'join', 'accept', 'exit','delete','invite'),
        Role::ADMINISTRATOR => array('findAdmin','buildAdmin','admin'),
    );

    /*
     * actionFind: find groups/show all groups
     */
    public function actionFind()
    {
        $page = $this->getHttpRequest()->getQuery('page',1);
        if($page<=0) $page = 1;

        $pagesize = $this->getHttpRequest()->getQuery('pagesize',6);

        $searchstr = '';
        if ($this->getHttpRequest()->isPostRequest()) $searchstr = ($_POST['searchstr']);
        else if(isset($_GET['search'])) $searchstr = $_GET['search'];

        $group = new Group();
        $group->name = trim($searchstr);
        $like = array();
        if (isset($group->name) && $group->name != '') {
            $names = explode(' ', $group->name);
            foreach ($names as $val) {
                array_push($like, array('key' => 'gro_name', 'value' => '%' . $val . '%'));
            }
            $group = new Group();
        }

        $groups = $group->find(0, 0, array('key'=>'gro_id',"order"=>"desc"), $like);
        $groupSum = count($groups);

        $groups = $group->find($pagesize * ($page - 1), $pagesize, array('key'=>'gro_id',"order"=>"desc"), $like);


        $this->setHeaderTitle("Find Group");
        $data = array('group' => $groups);
        if ($searchstr != '') $data['searchstr'] = $searchstr;

        $url = '';
        if($searchstr!='')
            $url = RHtmlHelper::siteUrl('group/find?search='.urlencode($searchstr));
        else
            $url = RHtmlHelper::siteUrl('group/find');

        $pager = new RPagerHelper('page',$groupSum,$pagesize, $url,$page);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render("find", $data, false);
    }

    /*
     * actionView: view my groups
     */
    public function actionView($userId = null)
    {
        $userGroup = new GroupUser();
        if($userId == null) $userId = Rays::app()->getLoginUser()->id;
        $userGroup = $userGroup->userGroups($userId);
        $this->setHeaderTitle("My Groups");
        $this->render("view", $userGroup, false);
    }

    public function actionDetail($groupId)
    {
        $data = array();

        $group = new Group();
        $group->load($groupId);
        $group->category->load();
        $group->groupCreator->load();
        $data['group'] = $group;

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

        $this->setHeaderTitle("Group details");
        $this->render('detail', $data, false);
    }

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

            $validation = new RFormValidationHelper($rules);
            if ($validation->run()) {
                // success
                $group = new Group();
                $group = $group->buildGroup($_POST['group-name'], $_POST['category'], RHtmlHelper::encode($_POST['intro']), Rays::app()->getLoginUser()->id);
                if (isset($_FILES['group_picture']) && ($_FILES['group_picture']['name'] != '')) {
                    $upload = new RUploadHelper(array('file_name' => 'group_' . $group->id . RUploadHelper::get_extension($_FILES['group_picture']['name']),
                        'upload_path' => Rays::getFrameworkPath() . '/../public/images/groups/'));
                    $upload->upload('group_picture');
                    if ($upload->error != '') {
                        $this->flash("error", $upload->error);
                    } else {
                        $group->picture = "public/images/groups/" . $upload->file_name;
                        $group->update();
                    }
                }
                $this->flash("message", "Group was built successfully.");
                $this->redirectAction('group', 'view', Rays::app()->getLoginUser()->id);
                return;
            } else {
                // validation failed
                $data['validation_errors'] = $validation->getErrors();
                $data['buildForm'] = $form;
            }
        } else {
            //
        }
        $this->addJs("/public/ckeditor/ckeditor.js");
        $this->render('build', $data, false);
    }

    public function actionEdit($groupId)
    {
        $oldGroup = new Group();
        $oldGroup->load($groupId);
        $this->setHeaderTitle("Edit my group");
        $category = new Category();
        $categories = $category->find();
        $data = array('categories' => $categories, 'groupId' => $groupId);
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;
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
                if (isset($_FILES['group_picture']) && $_FILES['group_picture']['name'] != '') {
                    $upload = new RUploadHelper(array('file_name' => 'group_' . $group->id . RUploadHelper::get_extension($_FILES['group_picture']['name']),
                        'upload_path' => Rays::getFrameworkPath() . '/../public/images/groups/'));
                    $upload->upload('group_picture');
                    if ($upload->error != '') {
                        $this->flash("error", $upload->error);
                    } else {
                        $group->picture = "public/images/groups/" . $upload->file_name;
                        $group->update();
                    }
                }
                $this->flash("message", "Edit group successfully.");
                $this->redirectAction('group', 'view', Rays::app()->getLoginUser()->id);
                return;
            } else {
                // validation failed
                $data['editForm'] = $form;
                $data['validation_errors'] = $validation->getErrors();
            }
        } else {
            $data['oldGroup'] = $oldGroup;
        }
        $this->addJs("/public/ckeditor/ckeditor.js");
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

            $content = "$currentUserName wants to join your group ".
                RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id)
                ."<br/>" .
                RHtmlHelper::link("Accept", "Accept", Rays::app()->getBaseUrl() . "/group/accept/{$censor->id}") . "<br/>" .
                RHtmlHelper::link("Decline", "Decline", Rays::app()->getBaseUrl() . "/group/decline/{$censor->id}");

            $message = new Message();
            $message->sendMsg("group", $currentUserId, $group->creator, "Join group request", $content, '');

            $this->flash('message', 'Joining group request has been sent.');
        }
        if(isset($_GET['returnurl']))
            $this->redirect($_GET['returnurl']);
        else
            $this->redirectAction('group','find');
    }

    public function actionAccept($censorId = null)
    {
        $censor = new Censor();
        $censor->id = $censorId;
        if ($censor->load() !==null) {
            $groupUser = new GroupUser();
            $groupUser->groupId = $censor->secondId;
            $groupUser->userId = $censor->firstId;
            date_default_timezone_set(Rays::app()->getTimeZone());
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

                $content = 'I have accepted your request of joining in group ' . RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
                $message = new Message();
                $message->sendMsg("group", Rays::app()->getLoginUser()->id, $groupUser->userId, "Join group request accepted", $content, '');

            }else{
                $this->flash("message","TA is already a member of this group.");
            }


            $censor->passCensor($censorId);
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
        $group->memberCount--;
        $group->update();

        $groupUser->delete();

        $this->flash("message", "You have exited the group successfully.");
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
                $checkedGroups = $_POST['checked_groups'];
                //var_dump($checkedGroups);
                foreach($checkedGroups as $group){
                    if(!is_numeric($group)) break;
                    $groupObj = new Group();
                    $groupObj->id = $group;
                    $groupObj->deleteGroup();
                }
            }
        }

        $rows = new Group();
        $count = $rows->count();
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = 4;
        $groups = new Group();
        //$groups = $groups->find(($curPage-1)*$pageSize,$pageSize,array('key'=>$groups->columns["id"],"order"=>'desc'));
        $groups = $groups->findAll(($curPage-1)*$pageSize,$pageSize,array('key'=>$groups->columns["id"],"order"=>'desc'));
        $data['groups'] = $groups;

        $pager = new RPagerHelper('page',$count,$pageSize,RHtmlHelper::siteUrl('group/admin'),$curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('admin',$data,false);
    }

    public function actionInvite($groupId){
        $data = array();

        $group = new Group();
        $group->load($groupId);
        $group->category->load();
        $group->groupCreator->load();
        $data['group'] = $group;

        $user = Rays::app()->getLoginUser();
        $friendsInGroup = array();
        $friends = new Friend();
        //$friends = $friends->getFriends($user->id,'',$friendsInGroup);
        $friends = $friends->getFriendsToInvite($user->id,$groupId);
        $data['friends'] = $friends;

        if ($this->getHttpRequest()->isPostRequest()) {
            $invitationMsg =$_POST['invitation'];
            $select_friends = $_POST['select_friends'];
            foreach($select_friends as $friendId){
                $msg = new Message();
                $content = RHtmlHelper::linkAction('user',Rays::app()->getLoginUser()->name,'view',Rays::app()->getLoginUser()->id).' invited you to join group '.RHtmlHelper::linkAction('group',$group->name,'detail',$groupId);
                $content = $content.'&nbsp;&nbsp;'.RHtmlHelper::linkAction('group','Accept invitation', 'join', $groupId,array('class' => 'btn btn-xs btn-info'));
                $content = $content.'</br>'.$invitationMsg;
                $content = RHtmlHelper::encode($content);
                $msg->sendMsg('group',Rays::app()->getLoginUser()->id,$friendId,'new group invitation',$content);
            }
            // show message
            $this->flash('message','Send invitation successfully.');
            $this->redirectAction('group','detail',$groupId);
            return;
        }

        $this->render('invite',$data,false);
    }
}