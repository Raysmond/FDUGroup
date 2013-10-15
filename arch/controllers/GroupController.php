<?php
/**
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 上午11:41
 */

class GroupController extends RController {
    public $layout = "index";
    public $defaultAction = "index";

    /*
     * actionFind: find groups/show all groups
     */
    public function actionFind($page = 1, $pagesize = 3)
    {
        $group = new Group();
        $groups = $group->find();
        $group_number = count($groups);
        $page_number = ceil($group_number/$pagesize);
        if($page == 1){
            $isFirstPage = true;
        }else
            $isFirstPage = false;
        if($page == $page_number){
            $isLastPage = true;
        }else
            $isLastPage = false;
        $group = new Group();
        if($page ==1)
            $groups = $group->find($pagesize);
        else
            $groups = $group->find($pagesize*($page-1),$pagesize);
        $this->setHeaderTitle("Find Group");
        $this->render("find",
            array('group'=>$groups,'page'=>$page,'isFirstPage'=>$isFirstPage,'isLastPage'=>$isLastPage,'pagesize'=>$pagesize,'page_number'=>$page_number),false);
    }

    /*
     * actionView: view my groups
     */
    public function actionView($userId = null)
    {
        if(! Rays::app()->isUserLogin()){
            $this->flash("message","Please login first!");
            $this->redirectAction('user','login');
            return;
        }
        $userGroup = new GroupUser();
        $userGroup = $userGroup->userGroups($userId);
        $this->setHeaderTitle("My Groups");
        $this->render("view",$userGroup,false);
    }

    public function actionDetail($groupId){
        $this->setHeaderTitle("Group details");
        $group = new Group();
        $group->load($groupId);
        $group->category->load();
        $group->groupCreator->load();
        $this->render('detail',array('group'=>$group),false);

    }

    public function actionBuild()
    {
        $this->setHeaderTitle("Build my group");
        $category = new Category();
        $categories =  $category->find();
        $data = array('categories'=>$categories);
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $rules = array(
                array('field'=>'group-name','label'=>'Group name','rules'=>'trim|required|min_length[5]|max_length[30]'),
                array('field'=>'category','label'=>'Category','rules'=>'required'),
                array('field'=>'intro','label'=>'Group Introduction','rules'=>'trim|required|min_length[10]')
            );

            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                // success
                $group = new Group();
                $group = $group->buildGroup($_POST['group-name'],$_POST['category'],$_POST['intro'],Rays::app()->getLoginUser()->id);
                if(isset($_FILES['group_picture'])&&($_FILES['group_picture']['name']!=''))
                {
                    $upload = new RUploadHelper(array('file_name'=>'group_'.$group->id.RUploadHelper::get_extension($_FILES['group_picture']['name']),
                        'upload_path'=>Rays::getFrameworkPath().'/../public/images/groups/'));
                    $upload->upload('group_picture');
                    if($upload->error!=''){
                        echo '<pre>';
                        print_r($upload);
                        echo '</pre>';
                        $this->flash("error",$upload->error);
                    }
                    else{
                        $group->picture = "public/images/groups/".$upload->file_name;
                        $group->update();
                    }
                }
                $this->flash("message","Group was built successfully.");
                $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
                return;
            }
            else{
                // validation failed
                $data['validation_errors'] = $validation->getErrors();
                $data['buildForm'] = $form;
            }
        }
        else{
            //
        }
        $this->render('build',$data,false);
    }

    public function actionEdit($groupId)
    {
        $oldGroup = new Group();
        $oldGroup->load($groupId);
        $this->setHeaderTitle("Edit my group");
        $category = new Category();
        $categories =  $category->find();
        $data = array('categories'=>$categories,'groupId'=>$groupId);
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $rules = array(
                array('field'=>'group-name','label'=>'Group name','rules'=>'trim|required|min_length[5]|max_length[30]'),
                array('field'=>'category','label'=>'Category','rules'=>'required'),
                array('field'=>'intro','label'=>'Group Introduction','rules'=>'trim|required|min_length[10]')
            );

            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                // success
                $group = new Group();
                $group->id = $groupId;
                $group->load();
                $group->name = $_POST['group-name'];
                $group->categoryId = $_POST['category'];
                $group->intro = $_POST['intro'];
                $group->update();
               // $group = $group->buildGroup($_POST['group-name'],$_POST['category'],$_POST['intro'],Rays::app()->getLoginUser()->id);
              if(isset($_FILES['group_picture'])&&$_FILES['group_picture']['name']!=''){
                    $upload = new RUploadHelper(array('file_name'=>'group_'.$group->id.RUploadHelper::get_extension($_FILES['group_picture']['name']),
                        'upload_path'=>Rays::getFrameworkPath().'/../public/images/groups/'));
                    $upload->upload('group_picture');
                    if($upload->error!=''){
                        echo '<pre>';
                        print_r($upload);
                        echo '</pre>';
                        $this->flash("error",$upload->error);
                    }
                    else{
                        $group->picture = "public/images/groups/".$upload->file_name;
                        $group->update();
                    }
                }
                $this->flash("message","Edit group successfully.");
                $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
                return;
            }
            else{
                // validation failed
                $data['editForm'] = $form;
                $data['validation_errors'] = $validation->getErrors();
            }
        }
        else{
            $data['oldGroup'] = $oldGroup;
        }
        $this->render('edit',$data,false);
    }

    public function actionJoin($groupId=null)
    {
        if(Rays::app()->isUserLogin()==false){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
            return;
        }
        else{
            $groupUser = new GroupUser();
            $groupUser->groupId = $groupId;
            $groupUser->userId = Rays::app()->getLoginUser()->id;
            date_default_timezone_set(Rays::app()->getTimeZone());
            $groupUser->joinTime = date('Y-m-d H:i:s');
            $groupUser->status = 1;
            $groupUser->insert();

            $group = new Group();
            $group->load($groupId);
            $group->memberCount++;
            $group->update();

            $this->flash("message","Congratulations. You have joined the group successfully.");
            $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
        }
    }

    public function actionExit($groupId=null)
    {
        if(Rays::app()->isUserLogin()==false){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
            return;
        }
        else{
            $groupUser = new GroupUser();
            $groupUser->groupId = $groupId;
            $groupUser->userId = Rays::app()->getLoginUser()->id;

            $group = new Group();
            $group->load($groupId);
            $group->memberCount--;
            $group->update();

            $groupUser->delete();

            $this->flash("message","You have exited the group successfully.");
            $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
        }
    }
}